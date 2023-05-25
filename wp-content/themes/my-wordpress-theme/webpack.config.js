const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const fs = require( 'fs' );
const path = require( 'path' );
const srcPath = 'src/';
const outputPath = 'assets/';

function getAllFiles( fileType, dirPath, entries ) {
	if ( ! ( fileType == 'js' || fileType === 'sass' ) ) {
		return;
	}
	const files = fs.readdirSync( dirPath );
	let fileEntries = entries || {};
	let extensionDir = 'js'
	let fileExtension = 'js';
	let outputDir = 'js';
	if ( fileType === 'sass' ) {
		extensionDir = 'sass'
		fileExtension = 'scss';
		outputDir = 'css';
	}
	files.forEach( ( file ) => {
		if ( fs.statSync( path.resolve( dirPath, file ) ).isDirectory() ) {
			fileEntries = getAllFiles( fileType, path.resolve( dirPath, file ), fileEntries );
			return;
		}
		if ( file.endsWith( `.${fileExtension}` ) && ! file.startsWith('_') ) {
			let entryPath = dirPath.replace( path.resolve(__dirname, srcPath, extensionDir), '' ).replace(/\//g, '.');
			let fileName = file.replace( `.${fileExtension}`, '' );
			if ( entryPath.startsWith('.') ) {
				entryPath = entryPath.substring(1);
			}
			if ( entryPath.length > 0 ) {
				fileName = `${entryPath}.${fileName}`;
			}
			fileEntries[
				`${outputDir}/${fileName}`
			] = path.resolve( dirPath, file );
		}
	});

	return entries;
}

function getAssetsEntryPoints() {
	const srcDir = path.resolve( __dirname, srcPath );
	const jsDir = path.resolve( srcDir, 'js' );
	const cssDir = path.resolve( srcDir, 'sass' );
	const jsEntries = getAllFiles( 'js', jsDir, {} );
	const cssEntries = getAllFiles( 'sass', cssDir, {} );

	return { ...jsEntries, ...cssEntries };
}

module.exports = {
	...defaultConfig,
	entry: getAssetsEntryPoints,
	output: {
		path: path.resolve( __dirname, outputPath ),
		filename: '[name].js',
	},
	resolve: {
		...defaultConfig.resolve,
		alias: {
			...defaultConfig.resolve.alias,
			Assets: path.resolve(
				__dirname,
				'src/'
			),
		},
	},
	module: {
		...defaultConfig.module,
		rules: defaultConfig.module.rules.map( ( rule ) => {
			if ( rule.test.toString() === '/\\.(sc|sa)ss$/' ) {
				return {
					...rule,
					use: rule.use.map( ( loader ) => {
						if ( loader.loader.includes( '/css-loader/' ) ) {
							return {
								...loader,
								options: {
									...loader.options,
									url: false,
								},
							};
						}
						return loader;
					} ),
				};
			}
			return rule;
		} ),
	},
	plugins: [
		...defaultConfig.plugins.filter(
			( plugin ) =>
				plugin.constructor.name !== 'DependencyExtractionWebpackPlugin'
		),
		new DependencyExtractionWebpackPlugin( {
			combineAssets: true,
			outputFormat: 'php',
		} ),
	],
};
