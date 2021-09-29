#define FFI_SCOPE "sdl_image"
#define FFI_LIB "libSDL2_image-2.0.so"

typedef uint8_t Uint8;
typedef uint16_t Uint16;
typedef uint32_t Uint32;
typedef int8_t Sint8;
typedef int16_t Sint16;
typedef int32_t Sint32;

void *IMG_Load(const char *file);
