<?php

namespace Quasilyte\SDLite;

class Renderer {
    /** @param ffi_cdata<sdl, struct SDL_Renderer*> $renderer */
    public function __construct(SDL $sdl, $renderer) {
        $this->corelib = $sdl->corelib;
        $this->renderer = $renderer;
    }

    public function present() {
        $this->corelib->SDL_RenderPresent($this->renderer);
    }

    public function clear(): bool {
        return $this->corelib->SDL_RenderClear($this->renderer) === 0;
    }

    /**
     * @param ffi_cdata<sdl, struct SDL_Texture*> $texture
     * @param ffi_cdata<sdl, struct SDL_Rect*> $srcrect
     * @param ffi_cdata<sdl, struct SDL_Rect*> $dstrect
     */
    public function copy($texture, $srcrect, $dstrect): bool {
        return $this->corelib->SDL_RenderCopy($this->renderer, $texture, $srcrect, $dstrect) === 0;
    }


    public function setDrawColor(Color $color): bool {
        return $this->corelib->SDL_SetRenderDrawColor($this->renderer, $color->r, $color->g, $color->b, $color->a) === 0;
    }

    public function drawLine(int $x1, int $y1, int $x2, int $y2): bool {
        return $this->corelib->SDL_RenderDrawLine($this->renderer, $x1, $y1, $x2, $y2) === 0;
    }

    /** @var ffi_scope<sdl> */
    private $corelib;
    /** @var ffi_cdata<sdl, struct SDL_Renderer*> */
    private $renderer;
}
