<?php
namespace App\Repositories;

use App\Models\Company;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveRepository {

    public function uploadFile(Request $request, $fileName = null) {
        $created_by = Auth::user()->id;
        $upload     = $request->file($fileName ?? 'file');
        $path       = $upload->getRealPath();
        $file       = file_get_contents($path);
        $base64     = base64_encode($file);
        $file = [
            'name'          =>  $upload->getClientOriginalName(),
            'mime'          =>  $upload->getClientMimeType(),
            'size'          =>  number_format(($upload->getSize() / 1024), 1),
            'attachment'    =>  'data:'.$upload->getClientMimeType().';base64,'.$base64,
            'created_by'    =>  $created_by
        ];
        $info = Media::create($file);
        return $info->id;
    }

    public function Company(Request $request,$id)
    {
        $created_by = Auth::user()->id;

        if (!empty($id)) {
            $info = Company::find($id);

            if (!empty($info)){
                $info->name             =   $request->name;
                $info->name_l           =   $request->name_l;
                $info->address          =   $request->address;
                $info->email            =   $request->email;
                $info->phone            =   $request->phone;
                $info->trade_license    =   $request->trade_license;
                $info->vat              =   $request->vat;
                $info->vat_area_code    =   $request->vat_area_code;
                $info->mashuk_no        =   $request->mashuk_no;
                $info->tin              =   $request->tin;
                $info->registration_no  =   $request->registration_no;
                $info->updated_by       =   $created_by;

                DB::beginTransaction();
                try {
                    $info->save();
                    DB::commit();
                    return 'success';
                } catch (Exception $e) {
                    DB::rollback();
                    return $e;
                }
            }
            else{
                return  "No record found";
            }
        }

        $data = [
            'name'                  => $request->name,
            'name_l'                => $request->name_l,
            'address'               => $request->address,
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'trade_license'         => $request->trade_license,
            'vat'                   => $request->vat,
            'vat_area_code'         => $request->vat_area_code,
            'mashuk_no'             => $request->mashuk_no,
            'tin'                   => $request->tin,
            'registration_no'       => $request->registration_no,
            'created_by'            => $created_by,
        ];

        DB::beginTransaction();
        try {
            Company::create($data);
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}