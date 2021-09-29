<?php

namespace Quasilyte\SDLite;

class EventType {
    const QUIT = 0x100 + 0;
    const APP_TERMINATING = 0x100 + 1;
    const APP_LOWMEMORY = 0x100 + 2;
    const APP_WILLENTERBACKGROUND = 0x100 + 3;
    const APP_DIDENTERBACKGROUND = 0x100 + 4;
    const APP_WILLENTERFOREGROUND = 0x100 + 5;
    const APP_DIDENTERFOREGROUND = 0x100 + 6;
    const LOCALECHANGED = 0x100 + 7;

    const DISPLAYEVENT = 0x150;

    const KEYDOWN = 0x300 + 0;
    const KEYUP = 0x300 + 1;
    const TEXTEDITING = 0x300 + 2;
    const TEXTINPUT = 0x300 + 3;
    const KEYMAPCHANGED = 0x300 + 4;

    const MOUSEMOTION = 0x400 + 0;
    const MOUSEBUTTONDOWN = 0x400 + 1;
    const MOUSEBUTTONUP = 0x400 + 2;
    const MOUSEWHEEL = 0x400 + 3;

    const JOYAXISMOTION = 0x600 + 0;
    const JOYBALLMOTION = 0x600 + 1;
    const JOYHATMOTION = 0x600 + 2;
    const JOYBUTTONDOWN = 0x600 + 3;
    const JOYBUTTONUP = 0x600 + 4;
    const JOYDEVICEADDED = 0x600 + 5;
    const JOYDEVICEREMOVED = 0x600 + 6;

    const CONTROLLERAXISMOTION = 0x650 + 0;
    const CONTROLLERBUTTONDOWN = 0x650 + 1;
    const CONTROLLERBUTTONUP = 0x650 + 2;
    const CONTROLLERDEVICEADDED = 0x650 + 3;
    const CONTROLLERDEVICEREMOVED = 0x650 + 4;
    const CONTROLLERDEVICEREMAPPED = 0x650 + 5;
    const CONTROLLERTOUCHPADDOWN = 0x650 + 6;
    const CONTROLLERTOUCHPADMOTION = 0x650 + 7;
    const CONTROLLERTOUCHPADUP = 0x650 + 8;
    const CONTROLLERSENSORUPDATE = 0x650 + 9;

    const FINGERDOWN = 0x700 + 0;
    const FINGERUP = 0x700 + 1;
    const FINGERMOTION = 0x700 + 2;

    const DOLLARGESTURE = 0x800 + 0;
    const DOLLARRECORD = 0x800 + 1;
    const MULTIGESTURE = 0x800 + 2;

    const CLIPBOARDUPDATE = 0x900;

    const DROPFILE = 0x1000 + 0;
    const DROPTEXT = 0x1000 + 1;
    const DROPBEGIN = 0x1000 + 2;
    const DROPCOMPLETE = 0x1000 + 3;

    const AUDIODEVICEADDED = 0x1100 + 0;
    const AUDIODEVICEREMOVED = 0x1100 + 1;

    const RENDER_TARGETS_RESET = 0x2000 + 0;
    const RENDER_DEVICE_RESET = 0x2000 + 1;

    const SDL_USEREVENT = 0x8000;
}
