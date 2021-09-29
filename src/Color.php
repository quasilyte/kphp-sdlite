<?php

namespace Quasilyte\SDLite;

class Color {
    public int $r;
    public int $g;
    public int $b;
    public int $a;

    public function __construct($r, $g, $b, $a = 255) {
        $this->r = $r;
        $this->g = $g;
        $this->b = $b;
        $this->a = $a;
    }
}
