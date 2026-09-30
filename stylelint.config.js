export default {
	extends: [
		'stylelint-config-recommended-scss',
	],

	ignoreFiles: [
		'assets/dist/**/*.css',
	],

	rules: {
		/**
		 * Sass imports are intentionally interleaved with Foundation mixin
		 * output so WebsiteNI custom styles remain last in the cascade.
		 */
		'no-invalid-position-at-import-rule': null,
	},

	overrides: [
		{
			files: [
				'assets/styles/scss/_settings.scss',
				'assets/styles/scss/helper/_effects.scss',
			],
			rules: {
				'scss/operator-no-unspaced': null,
				'scss/operator-no-newline-before': null,
			},
		},
	],
};
