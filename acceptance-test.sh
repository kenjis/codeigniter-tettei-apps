#!/bin/sh

## 強制的にtestingモードに
touch public/testing

vendor/bin/codecept -vvv run acceptance $@

## testingモードを止める
rm public/testing
