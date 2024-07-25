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
            $replacements["$$field$"] = $user->{$field};
        }

        $parsed = strtr($template, $replacements);

        return $parsed;
    }
}