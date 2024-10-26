<?php

namespace App\Http\Controllers;

use App\Models\Rt;
use App\Models\Dusun;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OrtuController extends Controller
{
    //
    public function index()
    {
        $orangtua = Orangtua::with('dusun')->get();
        return view('pages.main.orangtua.index', compact('orangtua'));
    }
    //VIEW ADD BALITA
    public function add()
    {
        $dusuns = Dusun::all();
        return view('pages.main.orangtua.add', compact('dusuns'));
    }
    // Ambil JSON RT by Dusun
    public function getRtByDusun($dusunId)
    {
        return response()->json(Rt::where('dusun_id', $dusunId)->get());
    }

    // Ambil JSON RW by Dusun
    public function getRwByDusun($dusunId)
    {
        return response()->json(Dusun::where('id', $dusunId)->pluck('rw'));
    }

    // STORE DATA ORANGTUA
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            'no_kk' => ['required', 'numeric', 'digits:16'], // Memastikan hanya angka dengan panjang tepat 16
            'nik' => ['required', 'numeric', 'digits:16'],   // Memastikan hanya angka dengan panjang tepat 16
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'telp' => 'required',
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
            'nik.required' => 'NIK harus diisi',
            'nik.numeric' => 'NIK harus berisi angka saja',
            'nik.digits' => 'NIK harus berisi tepat 16 digit angka',
            'name.required' => 'Nama harus diisi',
            'name.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',
            'telp.required' => 'Telepon harus diisi',
            'provinsi.required' => 'Provinsi harus dipilih',
            'kabupaten.required' => 'Kabupaten harus dipilih',
            'kecamatan.required' => 'Kecamatan harus dipilih',
            'desa.required' => 'Desa harus dipilih',
            'dusun.required' => 'Dusun harus dipilih',
            'rt.required' => 'RT harus dipilih',
            'alamat.required' => 'Alamat lengkap harus diisi',
        ]);

        if ($validator->fails()) {
            // Log::error('Validation failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Orangtua::create([
            "no_kk" => $request->no_kk,
            "nik" => $request->nik,
            "name" => $request->name,
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
            'nik' => ['required', 'numeric', 'digits:16'],   // Memastikan hanya angka dengan panjang tepat 16
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'telp' => 'required',
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
            'nik.required' => 'NIK harus diisi',
            'nik.numeric' => 'NIK harus berisi angka saja',
            'nik.digits' => 'NIK harus berisi tepat 16 digit angka',
            'name.required' => 'Nama harus diisi',
            'name.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',
            'telp.required' => 'Telepon harus diisi',
            'provinsi.required' => 'Provinsi harus dipilih',
            'kabupaten.required' => 'Kabupaten harus dipilih',
            'kecamatan.required' => 'Kecamatan harus dipilih',
            'desa.required' => 'Desa harus dipilih',
            'dusun.required' => 'Dusun harus dipilih',
            'rt.required' => 'RT harus dipilih',
            'alamat.required' => 'Alamat lengkap harus diisi',
        ]);

        if ($validator->fails()) {
            // Log::error('Validation failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }


        Orangtua::find($id)->update([
            "no_kk" => $request->no_kk,
            "nik" => $request->nik,
            "name" => $request->name,
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

        return Redirect::route('orangtua.index')->with('successToast', 'Berhasil memperbaharui data orangtua.');
    }

    // DELETE ORANGTUA
    public function delete($id)
    {

        Orangtua::find($id)->delete();
        return Redirect::route('orangtua.index')->with('success', 'Orangtua berhasil dihapus.');
    }
}
