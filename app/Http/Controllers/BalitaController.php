<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Balita;
use App\Models\Orangtua;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BalitaController extends Controller
{
    //VIEW INDEX BALITA
    public function index()
    {
        $user = auth()->user();
        if ($user->posyandu_id !== null) {
            $balita = Balita::with(['posyandu', 'orangtua'])->where('posyandu_id', $user->posyandu_id)->get();
        } else {
            $balita = Balita::with(['posyandu', 'orangtua'])->get();
        }
        // return $balita;



        return view('pages.main.balita.index', compact('balita'));
    }
    //VIEW ADD BALITA
    public function add()
    {
        // Mendapatkan user yang login
        $user = auth()->user();

        // Dapatkan data posyandu
        $posyandus = Posyandu::all();

        // Ambil data orangtua berdasarkan posyandu user dan dusun orangtua
        if ($user->posyandu_id !== null) {
            $orangtua = Orangtua::where('dusun_id', $user->posyandu_id)->get();
        } else {
            $orangtua = Orangtua::all();
        }

        return view('pages.main.balita.add', compact('posyandus', 'orangtua'));
    }

    // Metode untuk mengambil posyandu berdasarkan dusun_id
    public function getPosyanduByDusunId($dusunId)
    {
        // Ambil posyandu pertama yang sesuai dengan dusun_id
        $posyandu = Posyandu::where('id', $dusunId)->first();

        // Kembalikan data dalam format JSON
        return response()->json($posyandu);
    }

    // STORE DATA BALITA
    public function store(Request $request)
    {

        $request->merge([
            'name' => ucwords(strtolower($request->name)), // Membuat kapital setiap awal kata
        ]);

        $nikRequired = $request->has('disableNIK') ? 'nullable' : 'required';

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'nik' => [$nikRequired, 'numeric', 'digits:16', 'unique:balita,nik'],   // Memastikan hanya angka dengan panjang tepat 16
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'orangtua' => 'required',
            'posyandu' => 'required',
            'family_order' => 'required',
            'bb_lahir' => 'required',
            'tb_lahir' => 'required',
        ], [
            'name.required' => 'Isi Nama balita',
            'name.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',
            'nik.required' => 'NIK balita harus di isi',
            'nik.numeric' => 'NIK harus berisi angka saja',
            'nik.digits' => 'NIK harus berisi tepat 16 digit angka',
            'nik.unique' => 'NIK sudah terdaftar. Silahkan cek di daftar balita.',
            'tgl_lahir.required' => 'Isi tanggal lahir balita',
            'gender.required' => 'Pilih jenis kelamin balita',
            'orangtua.required' => 'Pilih orangtua balita',
            'posyandu.required' => 'Pilih posyandu balita',
            'family_order.required' => 'Isi kolom anak ke berapa',
            'bb_lahir.required' => 'Isi berat badan saat lahir',
            'tb_lahir.required' => 'Isi panjang badan saat Lahir',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Balita::create([
            "name" => $request->name,
            "nik" => $request->nik,
            "tgl_lahir" => $request->tgl_lahir,
            "gender" => $request->gender,
            "orangtua_id" => $request->orangtua,
            "posyandu_id" => $request->posyandu,
            "family_order" => $request->family_order,
            "bb_lahir" => $request->bb_lahir,
            "tb_lahir" => $request->tb_lahir,
            "created_by" => Auth::id(),

        ]);
        return Redirect::route('balita.index')->with('successToast', 'Berhasil Menambahkan Balita.');
    }

    // EDIT VIEW
    // public function edit($id)
    // {


    //     $balita = Balita::find($id);
    //     // Mendapatkan user yang login
    //     $user = auth()->user();

    //     // Dapatkan data posyandu
    //     $posyandus = Posyandu::all();

    //     // Ambil data orangtua berdasarkan posyandu user dan dusun orangtua
    //     if ($user->posyandu_id !== null) {
    //         $orangtua = Orangtua::where('dusun_id', $user->posyandu_id)->get();
    //     } else {
    //         $orangtua = Orangtua::all();
    //     }

    //     return view('pages.main.balita.edit', compact('balita', 'posyandus', 'orangtua'));
    // }

    public function edit($id)
    {
        $user = auth()->user();
        $posyandus = Posyandu::all();
        $queryBalita = Balita::query();
        $queryOrtu = Orangtua::query();
        if ($user->posyandu_id !== null) {
            $queryBalita->where('posyandu_id', $user->posyandu_id);
            $queryOrtu->where('dusun_id', $user->posyandu_id);
        }
        if ($id) {
            $queryBalita->where('id', $id);
        }
        $balita = $queryBalita->first();
        $orangtua = $queryOrtu->get();
        return view('pages.main.balita.edit', compact('balita', 'posyandus', 'orangtua'));
    }

    public function update(Request $request, $id)
    {


        $request->merge([
            'name' => ucwords(strtolower($request->name)), // Membuat kapital setiap awal kata
        ]);

        $nikRequired = $request->has('disableNIK') ? 'nullable' : 'required';

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'nik' => [$nikRequired, 'numeric', 'digits:16', Rule::unique('balita', 'nik')->ignore($id)], // Abaikan NIK yang sesuai dengan ID],   // Memastikan hanya angka dengan panjang tepat 16
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'orangtua' => 'required',
            'posyandu' => 'required',
            'family_order' => 'required',
            'bb_lahir' => 'required',
            'tb_lahir' => 'required',
        ], [
            'name.required' => 'Nama balita harus di isi',
            'name.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',
            'nik.required' => 'NIK harus di isi',
            'nik.numeric' => 'NIK harus berisi angka saja',
            'nik.digits' => 'NIK harus berisi tepat 16 digit angka',
            'nik.unique' => 'NIK sudah terdaftar. Silahkan cek di daftar balita.',
            'tgl_lahir.required' => 'Tanggal Lahir harus di isi',
            'gender.required' => 'Jenis Kelamin harus di isi',
            'orangtua.required' => 'Orangtua harus di pilih',
            'posyandu.required' => 'Posyandu harus di pilih',
            'family_order.required' => 'Kolom anak ke berapa harus di isi',
            'bb_lahir.required' => 'Berat Badan saat lahir harus di isi',
            'tb_lahir.required' => 'Panjang Badan saat Lahir harus di isi',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }
        Balita::find($id)->update([
            "name" => $request->name,
            "nik" => $request->nik,
            "tgl_lahir" => $request->tgl_lahir,
            "gender" => $request->gender,
            "orangtua_id" => $request->orangtua,
            "posyandu_id" => $request->posyandu,
            "family_order" => $request->family_order,
            "bb_lahir" => $request->bb_lahir,
            "tb_lahir" => $request->tb_lahir,
            "updated_by" => Auth::id(),

        ]);
        return Redirect::route('balita.index')->with('successToast', 'Berhasil Memperbaharui Data Balita.');
    }

    // DELETE BALITA
    public function delete($id)
    {
        Balita::find($id)->delete();
        return Redirect::route('balita.index')->with('success', 'Data Balita berhasil di hapus.');
    }
}
