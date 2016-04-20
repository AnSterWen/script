#!/bin/bash
git clone https://github.com/gmarik/Vundle.vim.git ~/.vim/bundle/Vundle.vim
cat <<EOF >~/.vimrc
set nocompatible
filetype off
set rtp+=~/.vim/bundle/Vundle.vim  
call vundle#begin()  
set hlsearch
set backspace=2
set autoindent
set nu
set bg=dark
syntax enable
syntax on
set paste
set autoindent
Plugin 'gmarik/Vundle.vim' 
Plugin 'scrooloose/nerdtree'
Plugin 'scrooloose/syntastic'
let mapleader=","
map <leader>n :NERDTreeToggle <CR>
call vundle#end()
EOF
