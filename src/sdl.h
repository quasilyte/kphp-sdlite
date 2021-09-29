#define FFI_SCOPE "sdl"
#define FFI_LIB "libSDL2-2.0.so"

typedef uint8_t Uint8;
typedef uint16_t Uint16;
typedef uint32_t Uint32;
typedef int8_t Sint8;
typedef int16_t Sint16;
typedef int32_t Sint32;

typedef Sint32 SDL_Keycode;

typedef struct { void *_opaque; } SDL_Window;
typedef struct { void *_opaque; } SDL_Renderer;
typedef struct { void *_opaque; } SDL_Texture;

typedef struct {
  int x, y;
  int w, h;
} SDL_Rect;

typedef struct {
  int scancode;
  SDL_Keycode sym;
  Uint16 mod;
  Uint32 unused;
} SDL_Keysym;

typedef struct {
  Uint32 type;
  Uint32 timestamp;
  Uint32 windowID;
  Uint8 state;
  Uint8 repeat;
  Uint8 padding2;
  Uint8 padding3;
  SDL_Keysym keysym;
} SDL_KeyboardEvent;

typedef struct SDL_QuitEvent {
  Uint32 type;
  Uint32 timestamp;
} SDL_QuitEvent;

typedef struct {
  Uint32 type;
  Uint32 timestamp;
  Uint32 windowID;
  Uint8 event;
  Uint8 padding1;
  Uint8 padding2;
  Uint8 padding3;
  Sint32 data1;
  Sint32 data2;
} SDL_WindowEvent;

typedef struct {
  Uint32 type;
  Uint32 timestamp;
  Uint32 windowID;
  char text[32];
  Sint32 start;
  Sint32 length;
} SDL_TextEditingEvent;

typedef struct {
  Uint32 type;
  Uint32 timestamp;
  Uint32 windowID;
  Uint32 which;
  Uint32 state;
  Sint32 x;
  Sint32 y;
  Sint32 xrel;
  Sint32 yrel;
} SDL_MouseMotionEvent;

typedef union SDL_Event {
  Uint32 type;
  SDL_WindowEvent window;
  SDL_KeyboardEvent key;
  SDL_TextEditingEvent edit;
  SDL_MouseMotionEvent motion;
  SDL_QuitEvent quit;
} SDL_Event;

int SDL_Init(Uint32 flags);

const char *SDL_GetError();

SDL_Window *SDL_CreateWindow(const char *title, int x, int y, int w, int h, Uint32 flags);

SDL_Renderer *SDL_CreateRenderer(SDL_Window *window, int index, Uint32 flags);
void SDL_RenderPresent(SDL_Renderer *renderer);
int SDL_RenderClear(SDL_Renderer *renderer);
int SDL_RenderCopy(SDL_Renderer *renderer, SDL_Texture *texture, const SDL_Rect *srcrect, const SDL_Rect *dstrect);

int SDL_SetRenderDrawColor(SDL_Renderer *renderer, Uint8 r, Uint8 g, Uint8 b, Uint8 a);
int SDL_RenderDrawLine(SDL_Renderer *renderer, int x1, int y1, int x2, int y2);

SDL_Texture *SDL_CreateTextureFromSurface(SDL_Renderer *renderer, void *surface);
int SDL_QueryTexture(SDL_Texture *texture, Uint32 *format, int *access, int *w, int *h);
void SDL_FreeSurface(void *surface);

int SDL_PollEvent(SDL_Event *event);
void SDL_Delay(Uint32 ms);
