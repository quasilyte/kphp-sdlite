<?php

namespace Quasilyte\SDLite;

class EventType {
    public const QUIT = 0x100 + 0;
    public const APP_TERMINATING = 0x100 + 1;
    public const APP_LOWMEMORY = 0x100 + 2;
    public const APP_WILLENTERBACKGROUND = 0x100 + 3;
    public const APP_DIDENTERBACKGROUND = 0x100 + 4;
    public const APP_WILLENTERFOREGROUND = 0x100 + 5;
    public const APP_DIDENTERFOREGROUND = 0x100 + 6;
    public const LOCALECHANGED = 0x100 + 7;

    public const DISPLAYEVENT = 0x150;

    public const KEYDOWN = 0x300 + 0;
    public const KEYUP = 0x300 + 1;
    public const TEXTEDITING = 0x300 + 2;
    public const TEXTINPUT = 0x300 + 3;
    public const KEYMAPCHANGED = 0x300 + 4;

    public const MOUSEMOTION = 0x400 + 0;
    public const MOUSEBUTTONDOWN = 0x400 + 1;
    public const MOUSEBUTTONUP = 0x400 + 2;
    public const MOUSEWHEEL = 0x400 + 3;

    public const JOYAXISMOTION = 0x600 + 0;
    public const JOYBALLMOTION = 0x600 + 1;
    public const JOYHATMOTION = 0x600 + 2;
    public const JOYBUTTONDOWN = 0x600 + 3;
    public const JOYBUTTONUP = 0x600 + 4;
    public const JOYDEVICEADDED = 0x600 + 5;
    public const JOYDEVICEREMOVED = 0x600 + 6;

    public const CONTROLLERAXISMOTION = 0x650 + 0;
    public const CONTROLLERBUTTONDOWN = 0x650 + 1;
    public const CONTROLLERBUTTONUP = 0x650 + 2;
    public const CONTROLLERDEVICEADDED = 0x650 + 3;
    public const CONTROLLERDEVICEREMOVED = 0x650 + 4;
    public const CONTROLLERDEVICEREMAPPED = 0x650 + 5;
    public const CONTROLLERTOUCHPADDOWN = 0x650 + 6;
    public const CONTROLLERTOUCHPADMOTION = 0x650 + 7;
    public const CONTROLLERTOUCHPADUP = 0x650 + 8;
    public const CONTROLLERSENSORUPDATE = 0x650 + 9;

    public const FINGERDOWN = 0x700 + 0;
    public const FINGERUP = 0x700 + 1;
    public const FINGERMOTION = 0x700 + 2;

    public const DOLLARGESTURE = 0x800 + 0;
    public const DOLLARRECORD = 0x800 + 1;
    public const MULTIGESTURE = 0x800 + 2;

    public const CLIPBOARDUPDATE = 0x900;

    public const DROPFILE = 0x1000 + 0;
    public const DROPTEXT = 0x1000 + 1;
    public const DROPBEGIN = 0x1000 + 2;
    public const DROPCOMPLETE = 0x1000 + 3;

    public const AUDIODEVICEADDED = 0x1100 + 0;
    public const AUDIODEVICEREMOVED = 0x1100 + 1;

    public const RENDER_TARGETS_RESET = 0x2000 + 0;
    public const RENDER_DEVICE_RESET = 0x2000 + 1;

    public const SDL_USEREVENT = 0x8000;
}
