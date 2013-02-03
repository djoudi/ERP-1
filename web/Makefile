SRCDIR=src
DISTDIR=dist
CHECK=\033[32m✔\033[39m


#
# 
#
bootstrap:
	@echo "\nCompiling CoffeeScript...     \n\n"
	coffee -co ${SRCDIR}/js ${SRCDIR}/coffee/
	@echo "\n\n${CHECK} Done\n"
	@mkdir -p ${SRCDIR}/css/
	@echo "\nCompiling LESS with Recess... \n\n"
	recess --compress --compile ${SRCDIR}/less/app.less:${SRCDIR}/css/app.css
	@echo "\n\n${CHECK} Done\n"
	@echo "\nCompiling RequireJS...        \n\n"
	r.js -o name=config  appDir='${SRCDIR}' baseUrl="js" dir='${DISTDIR}' mainConfigFile='${SRCDIR}/js/config.js' optimizeCss='standart'
	@echo "\n\n${CHECK} Done\n"
	@rm ${DISTDIR}/build.txt
	@rm -r ${DISTDIR}/less
	@rm -r ${DISTDIR}/coffee
	@echo "Removing undesired files...                ${CHECK} Done"


watch:
	coffee --watch --output ${SRCDIR}/js/ --compile ${SRCDIR}/coffee/ & 
	recess --compile ${SRCDIR}/less/app.less:${SRCDIR}/css/app.css --watch &

