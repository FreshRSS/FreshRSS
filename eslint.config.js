import globals from "globals";
import js from "@eslint/js";
import neostandard from 'neostandard';
import stylistic from '@stylistic/eslint-plugin';

export default [
	{
		files: ["**/*.js"],
		languageOptions: {
			globals: {
				...globals.browser,
			},
			sourceType: "script",
		},
	},
	{
		ignores: [
			".git/",
			"**/*.min.js",
			"extensions/",
			"node_modules/",
			"p/scripts/vendor/",
			"vendor/",
			// Additional exclusions for Extensions:
			"symbolic/",
			"third-party/",
			"tmp/",
		],
	},
	js.configs.recommended,
	// stylistic.configs['recommended-flat'],
	...neostandard(),
	{
		plugins: {
			"@stylistic": stylistic,
		},
		rules: {
			"camelcase": "off",
			"eqeqeq": "off",
			"no-empty": ["error", { "allowEmptyCatch": true }],
			"no-unused-vars": ["error", {
				"args": "none",
				"caughtErrors": "none",
			}],
			"yoda": "off",
			"@stylistic/indent": ["warn", "tab", { "SwitchCase": 1 }],
			"@stylistic/linebreak-style": ["error", "unix"],
			"@stylistic/max-len": ["warn", 165],
			"@stylistic/no-tabs": "off",
			"@stylistic/quotes": ["off", "single", { "avoidEscape": true }],
			"@stylistic/quote-props": ["warn", "consistent"],
			"@stylistic/semi": ["warn", "always"],
			"@stylistic/space-before-function-paren": ["warn", {
				"anonymous": "always",
				"asyncArrow": "always",
				"named": "never",
			}],
		},
	},
];
