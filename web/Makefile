SRCDIR=src
DISTDIR=dist
CHECK=\033[32m✔\033[39m


#
# 
#
bootstrap:
	@echo "\nCompiling CoffeeScript...     \n\n"
	coffee -co ${SRCDIR}/app.js/ ${SRCDIR}/app/
	@echo "\n\n${CHECK} Done\n"
	@mkdir -p ${SRCDIR}/assets/css/
	@echo "\nCompiling LESS with Recess... \n\n"
	recess --compress --compile ${SRCDIR}/assets/less/app.less > ${SRCDIR}/assets/css/app.css
	@echo "\n\n${CHECK} Done\n"
	@echo "\nCompiling RequireJS...        \n\n"
	r.js -o name=config  appDir='${SRCDIR}' baseUrl="app.js/" dir='${DISTDIR}' mainConfigFile='${SRCDIR}/app.js/config.js' optimizeCss='standart'
	@echo "\n\n${CHECK} Done\n"
	@rm ${DISTDIR}/build.txt
	@echo "Removing undesired files...     	\n\n"
	@rm -r ${DISTDIR}/assets/less
	@rm -r ${DISTDIR}/app
	@echo "\n\n${CHECK} Done\n"


watch:
	coffee --watch --output ${SRCDIR}/app.js/ --compile ${SRCDIR}/app/ & 
	recess --compile ${SRCDIR}/assets/less/app.less:${SRCDIR}/assets/css/app.css --watch &
