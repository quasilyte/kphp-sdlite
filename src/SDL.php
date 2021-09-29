<?php

namespace Quasilyte\SDLite;

// Notes.
//
// 1. We're using void* for SDL_Surface as it's used between several FFI scope declarations.
//    We may try using FFI::cast to convert between these two, maybe perhaps unlikely...

class SDL {
    const AUDIO_U8     = 0x0008;
    const AUDIO_S8     = 0x8008;
    const AUDIO_U16LSB = 0x0010;
    const AUDIO_S16LSB = 0x8010;
    const AUDIO_U16MSB = 0x1010;
    const AUDIO_S16MSB = 0x9010;

    const KEYDOWN = 0x300;

    const RENDERER_SOFTWARE = 1;
    const RENDERER_ACCELERATED = 2;

    const WINDOWPOS_CENTERED = 805240832;

    const INIT_TIMER          = 1;
    const INIT_AUDIO          = 16;
    const INIT_VIDEO          = 32;
    const INIT_JOYSTICK       = 512;
    const INIT_HAPTIC         = 4096;
    const INIT_GAMECONTROLLER = 8192;
    const INIT_EVENTS         = 16384;
    const INIT_SENSOR         = 32768;
    const INIT_EVERYTHING     = (
        self::INIT_TIMER |
        self::INIT_AUDIO |
        self::INIT_VIDEO |
        self::INIT_EVENTS |
        self::INIT_JOYSTICK |
        self::INIT_HAPTIC |
        self::INIT_GAMECONTROLLER |
        self::INIT_SENSOR
    );

    public static function loadCoreLib() {
        \FFI::load(__DIR__ . '/sdl.h');
    }

    public static function loadImageLib() {
        \FFI::load(__DIR__ . '/sdl_image.h');
    }

    public static function loadMixerLib() {
        \FFI::load(__DIR__ . '/sdl_mixer.h');
    }

    public function __construct() {
        $this->corelib = \FFI::scope('sdl');
        $this->imagelib = \FFI::scope('sdl_image');
    }

    public function init(int $flags = self::INIT_EVERYTHING): bool {
        return $this->corelib->SDL_Init($flags) === 0;
    }

    /** @return ffi_cdata<sdl, struct SDL_Window*> */
    public function createWindow(string $title, int $x, int $y, int $w, int $h, int $flags = 0) {
        return $this->corelib->SDL_CreateWindow($title, $x, $y, $w, $h, $flags);
    }

    /**
     * @param ffi_cdata<sdl, struct SDL_Window*> $window
     * @return ffi_cdata<sdl, struct SDL_Renderer*>
     */
    public function createRenderer($window, int $index, int $flags = self::RENDERER_ACCELERATED) {
        return $this->corelib->SDL_CreateRenderer($window, $index, $flags);
    }

    /** @param ffi_cdata<sdl, struct SDL_Renderer*> $renderer */
    public function renderClear($renderer): bool {
        return $this->corelib->SDL_RenderClear($renderer) === 0;
    }

    /**
     * @param ffi_cdata<sdl, struct SDL_Renderer*> $renderer
     * @param ffi_cdata<sdl, struct SDL_Texture*> $texture
     * @param ffi_cdata<sdl, struct SDL_Rect*> $srcrect
     * @param ffi_cdata<sdl, struct SDL_Rect*> $dstrect
     */
    public function renderCopy($renderer, $texture, $srcrect, $dstrect): bool {
        return $this->corelib->SDL_RenderCopy($renderer, $texture, $srcrect, $dstrect) === 0;
    }

    /** @param ffi_cdata<sdl, struct SDL_Renderer*> $renderer */
    public function renderPresent($renderer) {
        $this->corelib->SDL_RenderPresent($renderer);
    }

    /** @return ffi_cdata<sdl_image, void*> */
    public function imgLoad(string $path) {
        return $this->imagelib->IMG_Load($path);
    }

    /**
     * @param ffi_cdata<sdl, struct SDL_Renderer*> $renderer
     * @param ffi_cdata<sdl_image, void*> $surface
     * @return ffi_cdata<sdl, struct SDL_Texture*>
     */
    public function createTextureFromSurface($renderer, $surface) {
        return $this->corelib->SDL_CreateTextureFromSurface($renderer, $surface);
    }

    /** @param ffi_cdata<sdl, void*> $surface */
    public function freeSurface($surface) {
        $this->corelib->SDL_FreeSurface($surface);
    }

    /** @param ffi_cdata<sdl, union SDL_Event> $event */
    public function pollEvent($event): bool {
        return $this->corelib->SDL_PollEvent(\FFI::addr($event)) === 1;
    }

    public function delay(int $ms) {
        $this->corelib->SDL_Delay($ms);
    }

    /**
     * @param ffi_cdata<sdl, struct SDL_Texture*> $texture
     * @param ffi_cdata<sdl, uint32_t*> $format
     * @param ffi_cdata<sdl, int*> $access
     * @param ffi_cdata<sdl, int*> $w
     * @param ffi_cdata<sdl, int*> $h
     */
    public function queryTexture($texture, $format, $access, $w, $h): int {
        return $this->corelib->SDL_QueryTexture($texture, $format, $access, $w, $h);
    }

    public function openAudio(int $frequency, int $format, int $channels, int $chunksize): bool {
        return $this->mixerlib->Mix_OpenAudio($frequency, $format, $channels, $chunksize) === 0;
    }

    /** @return ffi_cdata<sdl_mixer, struct Mix_Chunk*> */
    public function LoadWAV(string $filename) {
        return $this->mixerlib->Mix_LoadWAV_RW($this->mixerlib->SDL_RWFromFile($filename, "rb"), 1);
    }

    /** @param ffi_cdata<sdl_mixer, struct Mix_Chunk*> $chunk */
    public function PlayChannel(int $channel, $chunk, int $loops): bool {
        return $this->mixerlib->Mix_PlayChannelTimed($channel, $chunk, $loops, -1) !== -1;
    }

    /** @return ffi_cdata<sdl, struct SDL_Rect> */
    public function newRect() {
        return $this->corelib->new('struct SDL_Rect');
    }

    /** @return ffi_cdata<sdl, union SDL_Event> */
    public function newEvent() {
        return $this->corelib->new('union SDL_Event');
    }

    /** @var ffi_scope<sdl> */
    private $corelib = null;
    /** @var ffi_scope<sdl_image> */
    private $imagelib = null;
    /** @var ffi_scope<sdl_mixer> */
    private $mixerlib = null;
}
