# 🚀 Welcome to your new awesome project!

This project has been created using **webpack-cli**, you can now run

```
npm run build
```

or

```
yarn build
```

to bundle your application


.babelrc
{
  "plugins": ["@babel/syntax-dynamic-import"],
  "presets": [
    [
      "@babel/preset-env",
      {
        "modules": false,
        "targets": {
          "node": "current"
        }
      }
    ]
  ]
}
