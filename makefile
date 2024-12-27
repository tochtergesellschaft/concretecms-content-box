.PHONY: clean fetch merge build deploy

clean:
	git checkout ./ && git clean -d -f .

fetch:
	git fetch

merge:
	git merge

build.dev:
	npm run dev

build.prod:
	npm run prod

deployment.dev: clean fetch merge build.dev

deployment.prod: clean fetch merge build.prod
