<?php

namespace App\Classes;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class TemplateParser
{
    public function parse(string $template, User $user) : string
    {
        $replacements = array();

        $description = DB::select("DESCRIBE users");
        foreach($description as $desc) {
            $field = $desc->Field;
            if ($field == 'picture') {
                $replacements["$$field$"] = '<div style="text-align:center;width:100%;"><img src="'. $user->{$field}.'" width="400px;" /></div>';
            }
            else {
                $replacements["$$field$"] = $user->{$field};
            }
        }

        $parsed = strtr($template, $replacements);

        return $parsed;
    }
}