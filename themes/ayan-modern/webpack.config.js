const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
const RemoveEmptyScriptsPlugin = require( 'webpack-remove-empty-scripts' );

module.exports = {
	...defaultConfig,
	entry: {
		'css/theme': path.resolve( __dirname, 'assets/scss/theme.scss' ),
		'js/theme': path.resolve( __dirname, 'assets/js/src/main.js' ),
		'js/editor': path.resolve( __dirname, 'assets/js/src/editor.js' ),
	},
	output: {
		...defaultConfig.output,
		path: path.resolve( __dirname, 'assets' ),
		filename: '[name].js',
		clean: {
			keep: ( asset ) =>
				asset.startsWith( 'js/src/' ) ||
				asset.startsWith( 'scss/' ) ||
				asset.startsWith( 'fonts/' ),
		},
	},
	plugins: [
		...defaultConfig.plugins.filter(
			( plugin ) => plugin.constructor.name !== 'CleanWebpackPlugin'
		),
		new RemoveEmptyScriptsPlugin(),
	],
};
