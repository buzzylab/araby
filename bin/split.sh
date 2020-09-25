#!/usr/bin/env bash

set -e
set -x

CURRENT_BRANCH="master"

function split()
{
    SHA1=`./bin/splitsh-lite --prefix=$1`
    git push $2 "$SHA1:refs/heads/$CURRENT_BRANCH" -f
}

function remote()
{
    git remote add $1 $2 || true
}

git pull origin $CURRENT_BRANCH

remote araby-charset git@github.com:buzzylab/araby-charset.git
remote araby-compress git@github.com:buzzylab/araby-compress.git
remote araby-date git@github.com:buzzylab/araby-date.git
remote araby-gender git@github.com:buzzylab/araby-gender.git
remote araby-glyphs git@github.com:buzzylab/araby-glyphs.git
remote araby-hiero git@github.com:buzzylab/araby-hiero.git
remote araby-identifier git@github.com:buzzylab/araby-identifier.git
remote araby-key-swap git@github.com:buzzylab/araby-key-swap.git
remote araby-make-time git@github.com:buzzylab/araby-maketime.git
remote araby-normalize git@github.com:buzzylab/araby-normalize.git
remote araby-numbers git@github.com:buzzylab/araby-numbers.git
remote araby-query git@github.com:buzzylab/araby-query.git
remote araby-salat git@github.com:buzzylab/araby-salat.git
remote araby-soundex git@github.com:buzzylab/araby-soundex.git
remote araby-standard git@github.com:buzzylab/araby-standard.git
remote araby-stemmer git@github.com:buzzylab/araby-stemmer.git
remote araby-str-to-time git@github.com:buzzylab/araby-str-to-time.git
remote araby-summarize git@github.com:buzzylab/araby-summarize.git
remote araby-transliteration git@github.com:buzzylab/araby-transliteration.git
remote araby-word-tag git@github.com:buzzylab/araby-word-tag.git

split 'src/Araby/Charset' araby-charset
split 'src/Araby/Compress' araby-compress
split 'src/Araby/Date' araby-date
split 'src/Araby/Gender' araby-gender
split 'src/Araby/Glyphs' araby-glyphs
split 'src/Araby/Hiero' araby-hiero
split 'src/Araby/Identifier' araby-identifier
split 'src/Araby/KeySwap' araby-key-swap
split 'src/Araby/MakeTime' araby-make-time
split 'src/Araby/Normalize' araby-normalize
split 'src/Araby/Numbers' araby-numbers
split 'src/Araby/Query' araby-query
split 'src/Araby/Salat' araby-salat
split 'src/Araby/Soundex' araby-soundex
split 'src/Araby/Standard' araby-standard
split 'src/Araby/Stemmer' araby-stemmer
split 'src/Araby/StrToTime' araby-str-to-time
split 'src/Araby/Summarize' araby-summarize
split 'src/Araby/Transliteration' araby-transliteration
split 'src/Araby/WordTag' araby-word-tag
