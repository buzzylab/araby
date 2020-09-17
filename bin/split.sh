#!/usr/bin/env bash

set -e
set -x

CURRENT_BRANCH="1.x"

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
remote araby-keyswap git@github.com:buzzylab/araby-keyswap.git
remote araby-maketime git@github.com:buzzylab/araby-maketime.git
remote araby-normalize git@github.com:buzzylab/araby-normalize.git
remote araby-numbers git@github.com:buzzylab/araby-numbers.git
remote araby-query git@github.com:buzzylab/araby-query.git
remote araby-salat git@github.com:buzzylab/araby-salat.git
remote araby-soundex git@github.com:buzzylab/araby-soundex.git
remote araby-standard git@github.com:buzzylab/araby-standard.git
remote araby-stemmer git@github.com:buzzylab/araby-stemmer.git
remote araby-strtotime git@github.com:buzzylab/araby-strtotime.git
remote araby-summarize git@github.com:buzzylab/araby-summarize.git
remote araby-transliteration git@github.com:buzzylab/araby-transliteration.git
remote araby-wordtag git@github.com:buzzylab/araby-wordtag.git

split 'src/Buzzylab/ArabyCharset' araby-charset
split 'src/Buzzylab/ArabyCompress' araby-compress
split 'src/Buzzylab/ArabyDate' araby-date
split 'src/Buzzylab/ArabyGender' araby-gender
split 'src/Buzzylab/ArabyGlyphs' araby-glyphs
split 'src/Buzzylab/ArabyHiero' araby-hiero
split 'src/Buzzylab/ArabyIdentifier' araby-identifier
split 'src/Buzzylab/ArabyKeyswap' araby-keyswap
split 'src/Buzzylab/ArabyMaketime' araby-maketime
split 'src/Buzzylab/ArabyNormalize' araby-normalize
split 'src/Buzzylab/ArabyNumbers' araby-numbers
split 'src/Buzzylab/ArabyQuery' araby-query
split 'src/Buzzylab/ArabySalat' araby-salat
split 'src/Buzzylab/ArabySoundex' araby-soundex
split 'src/Buzzylab/ArabyStandard' araby-standard
split 'src/Buzzylab/ArabyStemmer' araby-stemmer
split 'src/Buzzylab/ArabyStrtotime' araby-strtotime
split 'src/Buzzylab/ArabySummarize' araby-summarize
split 'src/Buzzylab/ArabyTransliteration' araby-transliteration
split 'src/Buzzylab/ArabyWordtag' araby-wordtag
