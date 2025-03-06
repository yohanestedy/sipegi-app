<?php

namespace App\Http\Controllers;

use App\Models\Rt;
use App\Models\Dusun;
use App\Models\Orangtua;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrtuController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        if ($user->posyandu_id !== null) {
            $orangtua = Orangtua::where('dusun_id', $user->posyandu_id)->with(['dusun.posyandu', 'rt', 'balita', 'balitaNonaktif'])->orderBy('name_ibu', 'asc')->get();
        } else {

            $orangtua = Orangtua::with(['dusun.posyandu', 'rt', 'balita', 'balitaNonaktif'])->orderBy('name_ibu', 'asc')->get();
        }
        $posyandus = Posyandu::all();
        return view('pages.main.orangtua.index', compact('orangtua', 'posyandus'));
    }
    //VIEW ADD BALITA
    public function add()
    {
        $user = auth()->user();

        if ($user->posyandu_id !== null) {
            $dusuns = Dusun::where('id', $user->posyandu_id)->get();
        } else {
            $dusuns = Dusun::all();
        }

        return view('pages.main.orangtua.add', compact('dusuns'));
    }
    // Ambil JSON RT by Dusun
    public function getRtByDusun($dusunId)
    {
        return response()->json(Rt::where('dusun_id', $dusunId)->get());
    }

    // Ambil JSON RW by Dusun
    // public function getRwByDusun($dusunId)
    // {
    //     return response()->json(Dusun::where('id', $dusunId)->pluck('rw'));
    // }

    // STORE DATA ORANGTUA
    public function store(Request $request)
    {



        // Mengubah input nama menjadi huruf kapital
        $request->merge([
            'name_ibu' => ucwords(strtolower($request->name_ibu)), // Membuat kapital setiap awal kata
            'name_ayah' => ucwords(strtolower($request->name_ayah)), // Membuat kapital setiap awal kata
        ]);
        // return $request;
        $validator = Validator::make($request->all(), [
            'no_kk' => ['required', 'numeric', 'digits:16'], // Memastikan hanya angka dengan panjang tepat 16
            'nik_ibu' => ['nullable', 'numeric', 'digits:16', Rule::unique('orangtua', 'nik_ibu')],   // Memastikan hanya angka dengan panjang tepat 16
            'name_ibu' => ['required', 'regex:/^[a-zA-Z\s\.]+$/'],
            'nik_ayah' => ['nullable', 'numeric', 'digits:16', Rule::unique('orangtua', 'nik_ayah')],   // Memastikan hanya angka dengan panjang tepat 16
            'name_ayah' => ['required', 'regex:/^[a-zA-Z\s\.]+$/'],

            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'dusun' => 'required',
            'rt' => 'required',
            'alamat' => 'required',
        ], [
            'no_kk.required' => 'Nomor KK harus diisi',
            'no_kk.numeric' => 'Nomor KK harus berisi angka saja',
            'no_kk.digits' => 'Nomor KK harus berisi tepat 16 digit angka',

            'nik_ibu.nullable' => 'NIK Ibu boleh kosong',
            'nik_ibu.numeric' => 'NIK Ibu harus berisi angka saja',
            'nik_ibu.digits' => 'NIK Ibu harus berisi tepat 16 digit angka',
            'nik_ibu.unique' => 'NIK Ibu sudah terdaftar. Silahkan cek di daftar orangtua.',
            'name_ibu.required' => 'Nama Ibu harus diisi',
            'name_ibu.regex' => 'Nama Ibu tidak boleh mengandung angka atau karakter khusus',

            'nik_ayah.nullable' => 'NIK Ayah boleh kosong',
            'nik_ayah.numeric' => 'NIK Ayah harus berisi angka saja',
            'nik_ayah.digits' => 'NIK Ayah harus berisi tepat 16 digit angka',
            'nik_ayah.unique' => 'NIK Ayah sudah terdaftar. Silahkan cek di daftar orangtua.',
            'name_ayah.required' => 'Nama Ayah harus diisi',
            'name_ayah.regex' => 'Nama Ayah tidak boleh mengandung angka atau karakter khusus',

            'telp.required' => 'Telepon harus diisi',
            'provinsi.required' => 'Provinsi harus dipilih',
            'kabupaten.required' => 'Kabupaten harus dipilih',
            'kecamatan.required' => 'Kecamatan harus dipilih',
            'desa.required' => 'Desa harus dipilih',
            'dusun.required' => 'Dusun harus dipilih',
            'rt.required' => 'RT harus dipilih',
            'alamat.required' => 'Alamat harus diisi',
        ]);


        if ($validator->fails()) {
            // Log::error('Validation failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }


        Orangtua::create([
            "no_kk" => $request->no_kk,
            "nik_ibu" => $request->nik_ibu,
            "name_ibu" => $request->name_ibu,
            "nik_ayah" => $request->nik_ayah,
            "name_ayah" => $request->name_ayah,
            "telp" => $request->telp,
            "provinsi" => $request->provinsi,
            "kabupaten" => $request->kabupaten,
            "kecamatan" => $request->kecamatan,
            "desa" => $request->desa,
            "dusun_id" => $request->dusun,
            "rt_id" => $request->rt,
            "alamat" => $request->alamat,
            "created_by" => Auth::id(),
        ]);

        return Redirect::route('orangtua.index')->with('successToast', 'Berhasil menambahkan data orangtua.');
    }


    // EDIT ORANGTUA
    public function edit($id)
    {
        $dusuns = Dusun::all();
        $orangtua = Orangtua::find($id);
        return view('pages.main.orangtua.edit', compact('orangtua', 'dusuns'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'no_kk' => ['required', 'numeric', 'digits:16'], // Memastikan hanya angka dengan panjang tepat 16
            'nik_ibu' => ['nullable', 'numeric', 'digits:16', Rule::unique('orangtua', 'nik_ibu')->ignore($id)],   // Memastikan hanya angka dengan panjang tepat 16
            'name_ibu' => ['required', 'regex:/^[a-zA-Z\s\.]+$/'],
            'nik_ayah' => ['nullable', 'numeric', 'digits:16', Rule::unique('orangtua', 'nik_ayah')->ignore($id)],   // Memastikan hanya angka dengan panjang tepat 16
            'name_ayah' => ['required', 'regex:/^[a-zA-Z\s\.]+$/'],

            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'dusun' => 'required',
            'rt' => 'required',
            'alamat' => 'required',
        ], [
            'no_kk.required' => 'Nomor KK harus diisi',
            'no_kk.numeric' => 'Nomor KK harus berisi angka saja',
            'no_kk.digits' => 'Nomor KK harus berisi tepat 16 digit angka',

            'nik_ibu.nullable' => 'NIK boleh diisi',
            'nik_ibu.numeric' => 'NIK harus berisi angka saja',
            'nik_ibu.digits' => 'NIK harus berisi tepat 16 digit angka',
            'nik_ibu.unique' => 'NIK sudah terdaftar. Silahkan cek di daftar orangtua.',
            'name_ibu.required' => 'Nama harus diisi',
            'name_ibu.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',

            'nik_ayah.nullable' => 'NIK boleh diisi',
            'nik_ayah.numeric' => 'NIK harus berisi angka saja',
            'nik_ayah.digits' => 'NIK harus berisi tepat 16 digit angka',
            'nik_ayah.unique' => 'NIK sudah terdaftar. Silahkan cek di daftar orangtua.',
            'name_ayah.required' => 'Nama harus diisi',
            'name_ayah.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',

            'telp.required' => 'Telepon harus diisi',
            'provinsi.required' => 'Provinsi harus dipilih',
            'kabupaten.required' => 'Kabupaten harus dipilih',
            'kecamatan.required' => 'Kecamatan harus dipilih',
            'desa.required' => 'Desa harus dipilih',
            'dusun.required' => 'Dusun harus dipilih',
            'rt.required' => 'RT harus dipilih',
            'alamat.required' => 'Alamat harus diisi',
        ]);

        if ($validator->fails()) {
            // Log::error('Validation failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }


        Orangtua::find($id)->update([
            "no_kk" => $request->no_kk,
            "nik_ibu" => $request->nik_ibu,
            "name_ibu" => $request->name_ibu,
            "nik_ayah" => $request->nik_ayah,
            "name_ayah" => $request->name_ayah,
            "telp" => $request->telp,
            "provinsi" => $request->provinsi,
            "kabupaten" => $request->kabupaten,
            "kecamatan" => $request->kecamatan,
            "desa" => $request->desa,
            "dusun_id" => $request->dusun,
            "rt_id" => $request->rt,
            "alamat" => $request->alamat,
            "updated_by" => Auth::id(),
        ]);

        Orangtua::find($id)->balita()->update(['posyandu_id' => $request->dusun]);



        return Redirect::route('orangtua.index')->with('successToast', 'Berhasil memperbaharui data orangtua.');
    }

    // DELETE ORANGTUA
    public function delete($id)
    {

        Orangtua::find($id)->delete();
        return Redirect::route('orangtua.index')->with('success', 'Orangtua berhasil dihapus.');
    }
}
