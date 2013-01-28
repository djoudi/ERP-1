CHECK=\033[32m✔\033[39m


#
# 
#
bootstrap:
	cd ~/Dropbox/Desenvolvimento/Web/contatos-2.0/web/
	coffee -co src/js src/coffee/
	@echo "Compiling CoffeeScript...                  ${CHECK} Done"
	@mkdir -p src/css/
	recess --compress --compile src/less/app.less > src/css/app.css
	@echo "Compiling LESS with Recess...              ${CHECK} Done"
	r.js -o name=app  appDir='src' baseUrl="js" dir='dist' mainConfigFile='src/js/app.js' optimizeCss='standart'
	@echo "Compiling RequireJS...                     ${CHECK} Done"
	@rm dist/build.txt
	@rm -r dist/less
	@rm -r dist/coffee
	@rm -r src/css
	@echo "Removing undesired files...                ${CHECK} Done"