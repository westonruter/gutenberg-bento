# Gutenberg ❤️ Bento

An exploratory plugin for using [Bento components](https://amp.dev/documentation/guides-and-tutorials/start/bento_guide/) in [Gutenberg](https://github.com/WordPress/gutenberg).

## Background

Bento AMP offers well-tested, cross-browser compatible and accessible components that can be used on non-AMP pages without having to use AMP anywhere else.
Bento components are designed to be highly performant and contribute to an excellent page experience.

These components are not only available as custom elements, but also as React and Preact components with the same features and API.
That makes them an ideal candidate for use in the React-based Gutenberg editor.

Typically, with Gutenberg one has to write a block's Edit component in React and then replicate the same look and feel for the frontend without React, causing a lot of duplicate work.
With Bento this is no longer a problem.

## About this Plugin

This demo plugin shows how `<amp-base-carousel>` can be used to display an image carousel on the frontend, with the `BaseCarousel` React component doing the same in the editor,
removing the need for any duplication.

Thanks to the encapsulation advantages of custom elements like `<amp-base-carousel>`, other WordPress plugins and themes can't interfere with its look & feel.

While this plugin is only a proof-of-concept, it gives a glimpse at the possibilities of using Bento for Gutenberg block development, and the advantages that brings:

1. Great user experience and page experience
2. Reduced development and maintenance costs
3. Ensured feature parity between editor and frontend
4. No interference by other plugins and themes thanks to web components.

### AMP-first Sites

An added bonus of the `<amp-base-carousel>` component is that it can be used on an AMP-first site with very little work.

When using the official [AMP WordPress plugin](https://wordpress.org/plugins/amp/), all that's needed is to stop enqueuing the custom JavaScript & CSS for the component
and use `amp-bind` (`on=""`) where custom functionality like going to the next/previous slide is needed.

### File Structure

* `edit.js`: only used in the editor.
* `edit.css`: only used in the editor
* `carousel.view.js`: only used on the frontend.
* `view.css`: used both on the frontend and in the editor.

## Screenshots

The `<BaseCarousel>` carousel component in the editor:

![Carousel in the editor](https://user-images.githubusercontent.com/841956/127545477-478adba4-c8e1-4a69-b3da-a58dabf375a7.png)

The same carousel powered by `<amp-base-carousel>` on the frontend:

![Carousel on the frontend](https://user-images.githubusercontent.com/841956/127545504-9fa725b6-a52f-43c1-9da6-af4f4b0a9c69.png)

## Getting Started

1. Clone repository into `wp-content/plugins/gutenberg-bento` of your WordPress site.
2. Run `npm install`
3. Run `composer install`
4. Run `npm run build`
5. Go to your WordPress site and activate this plugin.

To set up WordPress locally, you can use something like [Local](https://localwp.com/).

## Known Issues / Notes / Questions

### Package Exports

A Bento React component can be imported as follows:

```js
import { BaseCarousel } from '@ampproject/amp-base-carousel/react';
```

The component's `package.json` file has `exports` entries for both `import` (ESM) and `require` (CommonJS).
This is supported by modern build tooling such as webpack v5.

At the same time, the package contains a `react.js` file pointing to the CommonJS version.
This is done to make the above import work in older build tooling software such as webpack v4.

So with webpack v4, the above import actually references the `react.js` file and ends up importing the CommonJS version.

Unfortunately, the [`@wordpress/scripts`](https://npmjs.com/package/@wordpress/scripts) utility still uses webpack v4,
which is why such workarounds like `react.js` are still necessary.

As soon as the ecosystem begins to upgrade, the benefits of `exports` and ESM imports can be fully leveraged even in WordPress land.

### Lack of Type Definitions

[GitHub issue](https://github.com/ampproject/amphtml/issues/34206)

Having some type definitions or even just keeping inline documentation in the npm package would help improve developer experience. 

### Lack of Changelog / Documentation

Every time a new AMP version is released, new versions of the npm packages are tagged as well, even if there were actually no changes to the component.

For this reason, it would be very helpful to maintain a changelog for each package in its `README`. There could also be some basic usage examples in there
to make usage easier.

### Missing CSS

[GitHub issue](https://github.com/ampproject/amphtml/issues/35413)

Bento uses [JSS](https://cssinjs.org/) for stylesheets, but the compiled React components only contain the class names, not the actual CSS.

As a workaround, the repository contains some manually copied CSS for use with the React component.

### React Fragments broken

Originally reported in this [GitHub issue](https://github.com/ampproject/amphtml/issues/35412), this bug has since been fixed. 🎉

### AMP Validation

For the AMP-first version of this carousel block, a few modifications are needed to ensure AMP validation:

* Prevent enqueueing CSS & JS for the Bento component. The AMP plugin handles this.
* Modify the custom Previous/Next buttons to use `amp-bind`
* Modify the markup to fix the `loop` attribute. The AMP validator expects a value for this boolean flag, which React omits.

There might be easier ways to do these modifications.

## Next Steps

Once the main issues reported on GitHub are resolved, this demo plugin can be updated accordingly to remove some of the workarounds it contains.

Then, further experimentation could be done with Bento + Gutenberg with other Bento components.
Especially since the list of [components in development](https://github.com/ampproject/amphtml/blob/main/build-system/compile/bundles.config.extensions.json) is growing,
more and more use cases can be covered.

In the near future, the Web Stories WordPress plugin is actually [a prime candidate](https://github.com/google/web-stories-wp/issues/8439) for converting to use Bento components.
It uses a combination of custom lightbox and carousel scripts and uses `amp-lightbox` and `amp-carousel` for the AMP version. With Bento, only one version would need to be maintained.
