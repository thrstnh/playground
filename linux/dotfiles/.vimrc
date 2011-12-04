"
" Thorsten Hillebrand .vimrc
" created  14.05.2007
"

""""""""""""""""""""""""""""
" GENERAL
""""""""""""""""""""""""""""
set grepprg=grep\ -nH\ $*

" UTF8
set enc=utf-8
set fenc=utf-8
set termencoding=utf-8
" get out of horrible vi-compatible mode
set nocompatible
" detect the type of file
filetype on
" load filetype plugin
filetype plugin on
filetype indent on
" history size
set history=1000
" enable error files and error jumping
set cf
" support all three in this order
set ffs=unix,dos,mac
" make sure it can save viminfo
set viminfo+=!
" none of these should be word dividers, so make them not be
set isk+=_,$,@,%,#,-
" syntax highlight
syntax on



""""""""""""""""""""""""""
" THEME/COLORS
""""""""""""""""""""""""""
set gfn=Monospace\ 10
set background=dark
"desert
if has("gui_running")
    colorscheme desert
else
    colorscheme desert
endif


""""""""""""""""""""""""""
" Files / Backup
""""""""""""""""""""""""""
" make no backup file
set nobackup
" where to pub backup file
"set backupdir=~/.vim/vimfiles/backup
" temp dir
"set directory=~/.vim/vimfiles/temp
" dump files for make
set makeef=error.err


""""""""""""""""""""""
" Vim UI
""""""""""""""""""""""
if has("gui_running")
    " space it out a little more (easier to read)
    set lsp=0
    " turn on wild menu
    set wildmenu
    " always show current positions along the bottom
    set ruler
    " command bar height is 2
    set cmdheight=2
    " turn on line numbers
    set number
    " no redraw while macros (faster)
    set lz
    " make backspace work normal
    set backspace=2
    " use mouse everywhere
    set mouse=a
    " shortens messages to avoid 'press a key' promt
    set shortmess=atI
    " tell us when anything is changed via :...
    set report=0
    " no bell
    set noerrorbells
endif

""""""""""""""""""""""""""""""""""""""
" Visual Cues
""""""""""""""""""""""""""""""""""""""
if has("gui_running")
    " show matching brackets
    set showmatch
    " how many tenths of a second to blink matching brackets for
    set mat=5
    " do not highlight searched for phrase
    set nohlsearch
    " BUT do highlight as you type you search phrase
    set incsearch
    " n lines tall
    set lines=28
    " n cols wide
    set columns=120
    " keep n lines(bottom/top) for scope
    set so=3
    " dont blink
    set novisualbell
    " no noises
    set noerrorbells
    " status line
    set statusline=%F%m%r%h%w\ [FORMAT=%{&ff}]\ [TYPE=%Y]\ [ASCII=\%03.3b]\ [HEX=\%02.2B]\ [POS=%04l,%04v][%p%%]\ [LEN=%L]
    " always show the status line
    set laststatus=2
endif


"""""""""""""""""""""""""""""""""""""""""""
" Text Formatting / Layout
"""""""""""""""""""""""""""""""""""""""""""
" see help (complex)
set fo=tcrqn
" autoindent
set ai
" set smartindent
set si
" do c-style indenting
set cindent
" tab spacing
set tabstop=4
" unify
set softtabstop=4
" unify
set shiftwidth=4
" spaces, no tabs
set expandtab
" do not wrap lines
set wrap


"""""""""""""""""""""""""""""""""""""""""""
" Folding
"""""""""""""""""""""""""""""""""""""""""""
" turn on folding
set foldenable
" make folding indent sensitive
set foldmethod=indent
" fold manually
set foldlevel=100
" dont open folds when you search into them
set foldopen-=search
" dont open folds when you undo stuff
set foldopen-=undo



"""""""""""""""""""""""""""""""""""""""""""
" OTHER
"""""""""""""""""""""""""""""""""""""""""""
" UTF-8 encoding
"set enc=utf-8
" Python specific PEP8
"autocmd FileType python setlocal expandtab shiftwidth=4 tabstop=4 softtabstop=4

" python run on <F5>
"#map <silent> <F5> :!python %<CR>
autocmd FileType python map <F5> :w<CR>:!python "%"<CR>

"au FileType python source ~/.vim/syntax/python.vim

augroup development
    autocmd!
    autocmd Filetype c,cpp setlocal cindent nowrap number textwidth=0
    autocmd FileType make,php,sh,java,javascript,perl,css,html,dosbatch,python,idlang setlocal nowrap number textwidth=0
    autocmd BufWrite *.cpp,*.h,*.c call UpdateCTags()
    autocmd Filetype taglist setlocal statusline=Taglist
augroup END

" LaTeX
augroup latex
    autocmd!
    autocmd FileType tex setlocal number 
    " spell
augroup END

