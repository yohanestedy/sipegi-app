<?php

if (!function_exists('warnaBadge')) {
    function warnaBadge($nilaiZscore)
    {
        if ($nilaiZscore > 3 || $nilaiZscore < -3) {
            return 'bg-light-danger1';
        } elseif ($nilaiZscore > 2 || $nilaiZscore < -2) {
            return 'bg-light-danger';
        } elseif ($nilaiZscore > 1 || $nilaiZscore < -1) {
            return 'bg-light-warning';
        } elseif ($nilaiZscore >= -1 && $nilaiZscore <= 1) {
            return 'bg-light-success';
        } else {
            return 'bg-secondary';
        }
    }
}
