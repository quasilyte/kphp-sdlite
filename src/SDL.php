<?php

namespace Quasilyte\SDLite;

// Notes.
//
// 1. We're using void* for SDL_Surface as it's used between several FFI scope declarations.
//    We may try using FFI::cast to convert between these two, maybe perhaps unlikely...
//
//
// FIXME/TODO.
//
// 2. SDL_Color is not a pointer type, but it's required in different FFI scopes.
//    We can't use void* hack here.
//    To avoid this problem, we're using a KPHP type Color and convert it to SDL_Color
//    when needed.

class SDL {
    public const AUDIO_U8     = 0x0008;
    public const AUDIO_S8     = 0x8008;
    public const AUDIO_U16LSB = 0x0010;
    public const AUDIO_S16LSB = 0x8010;
    public const AUDIO_U16MSB = 0x1010;
    public const AUDIO_S16MSB = 0x9010;

    public const RENDERER_SOFTWARE = 1;
    public const RENDERER_ACCELERATED = 2;

    public const WINDOWPOS_CENTERED = 805240832;

    public const INIT_TIMER          = 1;
    public const INIT_AUDIO          = 16;
    public const INIT_VIDEO          = 32;
    public const INIT_JOYSTICK       = 512;
    public const INIT_HAPTIC         = 4096;
    public const INIT_GAMECONTROLLER = 8192;
    public const INIT_EVENTS         = 16384;
    public const INIT_SENSOR         = 32768;
    public const INIT_EVERYTHING     = (
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

    public static function loadTTFLib() {
        \FFI::load(__DIR__ . '/sdl_ttf.h');
    }

    public function __construct() {
        $this->corelib = \FFI::scope('sdl');
        $this->imagelib = \FFI::scope('sdl_image');
        $this->mixerlib = \FFI::scope('sdl_mixer');
        $this->ttflib = \FFI::scope('sdl_ttf');
    }

    public function init(int $flags = self::INIT_EVERYTHING): bool {
        return $this->corelib->SDL_Init($flags) === 0;
    }

    public function initTTF(): bool {
        return $this->ttflib->TTF_Init() === 0;
    }

    public function getError(): string {
        return (string)$this->corelib->SDL_GetError();
    }

    /** @return ffi_cdata<sdl, struct SDL_Window*> */
    public function createWindow(string $title, int $x, int $y, int $w, int $h, int $flags = 0) {
        return $this->corelib->SDL_CreateWindow($title, $x, $y, $w, $h, $flags);
    }

    /**
     * @param ffi_cdata<sdl, struct SDL_Window*> $window
     * @return ffi_cdata<sdl, struct SDL_Renderer*>
     */
    public function createRenderer($window, int $index = -1, int $flags = self::RENDERER_ACCELERATED) {
        return $this->corelib->SDL_CreateRenderer($window, $index, $flags);
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

    /** @var ffi_cdata<sdl, struct SDL_Texture*> */
    public function destroyTexture($texture) {
        $this->corelib->SDL_DestroyTexture($texture);
    }

    /** @param ffi_cdata<sdl, struct SDL_Window*> $window */
    public function getWindowPixelFormat($window): int {
        return $this->corelib->SDL_GetWindowPixelFormat($window);
    }

    /**
     * @param ffi_cdata<sdl, void*> $src_surface
     * @return ffi_cdata<sdl, void*>
     */
    public function convertSurfaceFormat($src_surface, int $pixel_format, int $flags = 0) {
        return $this->corelib->SDL_ConvertSurfaceFormat($src_surface, $pixel_format, $flags);
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

    /** @return ffi_cdata<sdl_mixer, struct Mix_Music*> */
    public function loadMusic(string $filename) {
        return $this->mixerlib->Mix_LoadMUS($filename);
    }

    /** @param ffi_cdata<sdl_mixer, struct Mix_Music*> $music */
    public function playMusic($music, int $loops = -1): bool {
        return $this->mixerlib->Mix_PlayMusic($music, $loops) === 0;
    }

    /** @return ffi_cdata<sdl_mixer, struct Mix_Chunk*> */
    public function loadWAV(string $filename) {
        return $this->mixerlib->Mix_LoadWAV_RW($this->mixerlib->SDL_RWFromFile($filename, "rb"), 1);
    }

    /** @param ffi_cdata<sdl_mixer, struct Mix_Chunk*> $chunk */
    public function playChannel(int $channel, $chunk, int $loops): bool {
        return $this->mixerlib->Mix_PlayChannelTimed($channel, $chunk, $loops, -1) !== -1;
    }

    /** @return ffi_cdata<sdl_ttf, struct TTF_Font*> */
    public function openFont(string $path, int $ptsize) {
        return $this->ttflib->TTF_OpenFont($path, $ptsize);
    }

    /**
     * @param ffi_cdata<sdl_ttf, struct TTF_Font*> $font
     * @return ffi_cdata<sdl_ttf, void*>
     */
    public function renderTextSolid($font, string $text, Color $color) {
        $c_color = $this->convertColor($color);
        return $this->ttflib->TTF_RenderText_Solid($font, $text, $c_color);
    }

    /**
     * @param ffi_cdata<sdl_ttf, struct TTF_Font*> $font
     * @return ffi_cdata<sdl_ttf, void*>
     */
    public function renderTextBlended($font, string $text, Color $color) {
        $c_color = $this->convertColor($color);
        return $this->ttflib->TTF_RenderText_Blended($font, $text, $c_color);
    }

    /**
     * @param ffi_cdata<sdl_ttf, struct TTF_Font*> $font
     * @return ffi_cdata<sdl_ttf, void*>
     */
    public function renderUTF8Blended($font, string $text, Color $color) {
        $c_color = $this->convertColor($color);
        return $this->ttflib->TTF_RenderUTF8_Blended($font, $text, $c_color);
    }

    /**
     * @param ffi_cdata<sdl_ttf, struct TTF_Font*> $font
     * @return ffi_cdata<sdl_ttf, void*>
     */
    public function renderUTF8Shaded($font, string $text, Color $fg, Color $bg) {
        $c_fg = $this->convertColor($fg);
        $c_bg = $this->convertColor($bg);
        return $this->ttflib->TTF_RenderUTF8_Shaded($font, $text, $c_fg, $c_bg);
    }

    /**
     * @param ffi_cdata<sdl_ttf, struct TTF_Font*> $font
     * @return ffi_cdata<sdl_ttf, void*>
     */
    public function renderTextShaded($font, string $text, Color $fg, Color $bg) {
        $c_fg = $this->convertColor($fg);
        $c_bg = $this->convertColor($bg);
        return $this->ttflib->TTF_RenderText_Shaded($font, $text, $c_fg, $c_bg);
    }

    /**
     * @param ffi_cdata<sdl_ttf, struct TTF_Font*> $font
     * @return tuple(int, int)
     */
    public function sizeText($font, string $text) {
        $w = \FFI::new('int');
        $h = \FFI::new('int');
        if ($this->ttflib->TTF_SizeText($font, $text, \FFI::addr($w), \FFI::addr($h)) === 0) {
            return tuple($w->cdata, $h->cdata);
        }
        return tuple(-1, -1);
    }

    /**
     * @param ffi_cdata<sdl_ttf, struct TTF_Font*> $font
     * @return tuple(int, int)
     */
    public function sizeUTF8($font, string $text) {
        $w = \FFI::new('int');
        $h = \FFI::new('int');
        if ($this->ttflib->TTF_SizeUTF8($font, $text, \FFI::addr($w), \FFI::addr($h)) === 0) {
            return tuple($w->cdata, $h->cdata);
        }
        return tuple(-1, -1);
    }

    /** @return ffi_cdata<sdl, struct SDL_Rect> */
    public function newRect() {
        return $this->corelib->new('struct SDL_Rect');
    }

    /** @return ffi_cdata<sdl, union SDL_Event> */
    public function newEvent() {
        return $this->corelib->new('union SDL_Event');
    }

    /** @return ffi_cdata<sdl_ttf, struct SDL_Color> */
    private function convertColor(Color $color) {
        $c_color = $this->ttflib->new('struct SDL_Color');
        $c_color->r = $color->r;
        $c_color->g = $color->g;
        $c_color->b = $color->b;
        $c_color->a = $color->a;
        return $c_color;
    }

    /** @var ffi_scope<sdl> */
    public $corelib = null;
    /** @var ffi_scope<sdl_image> */
    public $imagelib = null;
    /** @var ffi_scope<sdl_mixer> */
    public $mixerlib = null;
    /** @var ffi_scope<sdl_ttf> */
    public $ttflib = null;
}

