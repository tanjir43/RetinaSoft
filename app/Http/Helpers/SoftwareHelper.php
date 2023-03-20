<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


    if(!function_exists('SetLog')) {
        function SetLog($msg) 
        {
            $user = Auth::user();
            $data = [
                'user_id'   => $user->id,
                'role_id'   => $user->role_id,
                'branch_id' => $user->branch_id,
                'msg'       => $msg,
                'created_at'=> now()
            ];

            if ($user->id != 1) {
                try {
                    DB::table('logs')->insert($data);
                } catch (\Throwable $th) {
                    return redirect()->back()->with(['errors' => [$th->getMessage()]]);
                }
            }
        }
    }

    if(!function_exists('DebugMe')) {
        function DebugMe($value, $die = 0) {
            echo '<pre>';
            if(is_array($value)) {
                print_r($value);
            } elseif(is_object($value)) {
                print_r($value);
            } else {
                echo $value;
            }
            echo '</pre>';
            if($die != 0) {
                die();
            }
        }
    }

    if(!function_exists('Organization')) {
        function Organization($name) {
            $orga = DB::table('organizations')->where('name',$name)->first();
            if(!empty($orga)) {
                return $orga;
            }
            return null;
        }
    }

    if (!function_exists('ConvertToLang')) {
        function ConvertToLang($object, $en = null, $local = null)
        {
            $lang = App::getLocale();
            if (empty($en) && empty($local)) {
                if ($lang == 'bn') {
                    if (!empty($object->name_l)) {
                        return $object->name_l;
                    } else {
                        return $object->name;
                    }
                } else {
                    return $object->name;
                }
            } else {
                if ($lang == 'bn') {
                    if (!empty($object->$local)) {
                        return $object->$local;
                    } else {
                        return $object->$en;
                    }
                } else {
                    return $object->$en;
                }
            }
        }
    }

    if(!function_exists('ConvertToLangPrint')) {
        function ConvertToLangPrint($object, $lan = null, $en = null, $local = null) {
            if(empty($en) && empty($local)) {
                if($lan != 'en') {
                    if(!empty($object->name_l)) {
                        return $object->name_l;
                    } else {
                        return $object->name;
                    }
                } else {
                    return $object->name;
                }
            } else {
                if($lan != 'en') {
                    if(!empty($object->$local)) {
                        return $object->$local;
                    } else {
                        return $object->$en;
                    }
                } else {
                    return $object->$en;
                }
            }
        }
    }