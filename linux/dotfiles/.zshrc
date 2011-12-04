#!/bin/zsh
# dotfile
# .zshrc
# Author: thrstnh
# email:  thrstn.hllbrnd@googlemail.com
# created 12.11.2007

# vi bindings
bindkey -v

# paranoid
umask 077

# completion
zmodload -i zsh/complist
autoload -U compinit && compinit

# colors
autoload -U colors && colors

# prompt
autoload -U promptinit && promptinit

. ~/.zsh/prompt
. ~/.zsh/opts
. ~/.zsh/function
. ~/.zsh/style
. ~/.zsh/bind
. ~/.zsh/export
. ~/.zsh/alias
. ~/.zsh/colors
