/** @type {import('tailwindcss').Config} */
module.exports = {
	important: true,
	content: [
		"./**/*.php",
		"./templates/admin/*.php",
		"./templates/frontend/*.php",
		"./templates/frontend/partials/*.php",
		"./templates/**/**/*.php",
		"./includes/**/*.php",
		"./includes/blocks/**/*.php"
	],
	prefix: 'tw-',
	theme: {
		extend: {
			colors: {
				transparent: 'transparent',
				current: 'currentColor',
				"tsmlx-headers": 'rgb(var(--tsmlx-headers-rgb) / <alpha-value>)',
				"tsmlx-primary": 'rgb(var(--tsmlx-primary-rgb) / <alpha-value>)',
				"tsmlx-secondary": 'rgb(var(--tsmlx-secondary-rgb) / <alpha-value>)',
				"tsmlx-tertiary": 'rgb(var(--tsmlx-tertiary-rgb) / <alpha-value>)',
                "c4r-blue": 'rgb(var(--c4r-blue) / <alpha-value>)',
                "c4r-lightblue": 'rgb(var(--c4r-lightblue) / <alpha-value>)',
                "c4r-gray": 'rgb(var(--c4r-gray) / <alpha-value>)',
			}
		},
	},
	safelist: [
		'tw-line-through',
        'tw-grid-cols-1',
        'tw-grid-cols-2',
        'tw-grid-cols-3',
        'tw-grid-cols-4',
        'tw-grid-cols-5',
        'tw-grid-cols-6',
        'tw-grid-cols-7',
        'tw-grid-cols-8',
        'tw-grid-cols-9',
        'tw-max-h-fit',
	]
}
