export default {
	js2svg: {
		indent: -1,
		pretty: true,
		eol: 'lf',
		finalNewline: true,
	},
	multipass: true,
	plugins: [ // https://svgo.dev/docs/plugins/
		'preset-default', // built-in plugins enabled by default
		'removeScripts',
	],
};
