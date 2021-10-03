#define FFI_SCOPE "sdl_mixer"
#define FFI_LIB "libSDL2_mixer-2.0.so"

typedef uint8_t Uint8;
typedef uint16_t Uint16;
typedef uint32_t Uint32;
typedef int8_t Sint8;
typedef int16_t Sint16;
typedef int32_t Sint32;

typedef struct Mix_Chunk Mix_Chunk;
typedef struct Mix_Music Mix_Music;
typedef struct SDL_RWops SDL_RWops;

int Mix_OpenAudio(int frequency, Uint16 format, int channels, int chunksize);

SDL_RWops *SDL_RWFromFile(const char *file, const char *mode);
Mix_Chunk *Mix_LoadWAV_RW(SDL_RWops *src, int freesrc);

Mix_Music *Mix_LoadMUS(const char *file);
int Mix_PlayMusic(Mix_Music *music, int loops);

int Mix_PlayChannelTimed(int channel, Mix_Chunk *chunk, int loops, int ticks);
