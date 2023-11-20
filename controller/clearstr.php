<?php
class Cleaner
{
    public function cleanPhoto($str) {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        $str = preg_replace('/[()-]/', '_', $str);
        $str = preg_replace('/[^a-z.0-9]/i', '_', $str);
        $str = preg_replace('/_+/', '_', $str);
        
        return $str;
    }

    public function cleanNumbers($str) {
        $str = preg_replace('/[áàãâä]/ui', '', $str);
        $str = preg_replace('/[éèêë]/ui', '', $str);
        $str = preg_replace('/[íìîï]/ui', '', $str);
        $str = preg_replace('/[óòõôö]/ui', '', $str);
        $str = preg_replace('/[úùûü]/ui', '', $str);
        $str = preg_replace('/[ç]/ui', '', $str);
        $str = preg_replace('/[ -,.()]/', '', $str);
        $str = preg_replace('/[^a-z.0-9]/i', '', $str);
        $str = preg_replace('/_+/', '', $str);
        
        return $str;
    }
}

?>