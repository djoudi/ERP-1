CHECK=\033[32m✔\033[39m


#
# 
#
bootstrap:
	@echo "\nCompiling CoffeeScript...     \n\n"
	coffee -co src/js src/coffee/
	@echo "\n\n${CHECK} Done\n"
	@mkdir -p src/css/
	@echo "\nCompiling LESS with Recess... \n\n"
	recess --compress --compile src/less/main.less > src/css/main.css
	@echo "\n\n${CHECK} Done\n"
	@echo "\nCompiling RequireJS...        \n\n"
	r.js -o name=main  appDir='src' baseUrl="js" dir='dist' mainConfigFile='src/js/config.js' optimizeCss='standart'
	@echo "\n\n${CHECK} Done\n"
	@rm dist/build.txt
	@rm -r dist/less
	@rm -r dist/coffee
	@echo "Removing undesired files...                ${CHECK} Done"

watch:
	coffee --watch --output js/ --compile coffee/ & 
	watchr -e 'watch(".*\.less$") { |f| new_file = f[0].gsub("less","css"); system("lessc #{f[0]} > #{new_file} && echo \"#{f[0]} > #{new_file}\" ") }' &
