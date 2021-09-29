#define FFI_SCOPE "sdl_ttf"
#define FFI_LIB "libSDL2_ttf-2.0.so"

typedef uint8_t Uint8;
typedef uint16_t Uint16;
typedef uint32_t Uint32;
typedef int8_t Sint8;
typedef int16_t Sint16;
typedef int32_t Sint32;

typedef struct { void *_opaque; } TTF_Font;

typedef struct SDL_Color {
  Uint8 r;
  Uint8 g;
  Uint8 b;
  Uint8 a;
} SDL_Color;

int TTF_Init();

TTF_Font *TTF_OpenFont(const char *file, int ptsize);

void *TTF_RenderText_Shaded(TTF_Font *font, const char *text, SDL_Color fg, SDL_Color bg);
void *TTF_RenderText_Blended(TTF_Font *font, const char *text, SDL_Color fg);
void *TTF_RenderText_Solid(TTF_Font *font, const char *text, SDL_Color fg);

int TTF_SizeText(TTF_Font *font, const char *text, int *w, int *h);
