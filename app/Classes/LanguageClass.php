<?php

namespace App\Classes;

use App\Models\Language;
use Yajra\DataTables\Facades\DataTables;

class LanguageClass
{
    public function getLanguages()
    {
        return Language::all();
    }

    public function toggleStatus()
    {
        try {
            $id = request()->get('id');
            $language = Language::find($id);
            if ($language) {
                $language->status = $language->status == 1 ? 0 : 1;
                $language->save();
                return ['status' => true, 'message' => "Language status updated successfully"];
            }
            return ['status' => false, 'message' => "Language not found"];
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "Error updating language status"];
        }
    }

    public function saveLanguage(){
        try {
            $name = request()->get('name');
            $code = request()->get('code');

            if ($name == null || $code == null) {
                return ['status' => false, 'message' => "Name and Code are required"];
            }

            $check = Language::where('code', $code)->first();
            if ($check) {
                return ['status' => false, 'message' => "Language Code already exists"];
            }

            $language = new Language();
            $language->name = $name;
            $language->code = $code;
            $language->status = 1;

            if ($language->save()) {
                return ['status' => true, 'message' => "Language added successfully"];
            } else {
                return ['status' => false, 'message' => "Language not saved successfully"];
            }
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "An error occurred during language save"];
        }
    }

    public function deleteLanguage(){
        try {
            $id = request()->get('id');
            $language = Language::find($id);
            if ($language) {
                $language->delete();
                return ['status' => true, 'message' => "Language deleted successfully"];
            }
            return ['status' => false, 'message' => "Language not found"];
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => "An error occurred during language deletion"];
        }
    }
}
