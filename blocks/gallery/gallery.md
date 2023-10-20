# Modula Gallery Block Development Guidelines

This document outlines the structure and guidelines for developing the Modula Gallery block. The code is organized into various folders and files to maintain a clean and manageable codebase.

## Folder Structure

-   `context/`: Contains context-related files for managing global state.
-   `components/`: Holds React components.
-   `hooks/`: Contains custom hooks.
-   `editor.scss`: Styling for the editor view.
-   `edit.js`: Main file for editing view of the block.

## File Breakdown

### `edit.js`

This is the main file for the editing view of the block. It imports necessary components and context providers.

-   Imports:
    -   `BlockProvider` from `context/BlockContext`.
    -   `InspectorControls` and `UiBlock` from `components/`.
-   `Edit` function:
    -   Defines `initialValues` object.
    -   Returns a component tree wrapped in `BlockProvider`.

### `context/BlockContext.js`

This file sets up and exports the `BlockContext` and `BlockProvider`.

-   `BlockContext`: A context created to provide a way for nested components to access and manipulate block-level data and functions.
-   `BlockProvider`:
    -   Accepts `initialValues`, `attributes`, `setAttributes` as props, along with any other necessary data or functions.
    -   Merges `initialValues` with `initialState` to provide a default state.
    -   Utilizes `useReducer` to manage state and actions.
    -   Defines a `value` object using `useMemo`, which can expose state, setter functions, and any other necessary data or functions to the context.

The `BlockContext` and `BlockProvider` serve as the foundation for global state management within the block, allowing for a structured and organized way to manage and share data and functions across components. This setup is designed to be flexible and extensible, allowing for additional data and functions to be added to the context as the block's functionality grows.

### `components/InspectorControls.js`

This component renders the block's settings in the sidebar.

-   Imports `InspectorControls` from `@wordpress/block-editor`.
-   Uses `useBlockContext` hook to access `attributes` and `setAttributes`.
-   Renders a `PanelBody` with a `TextControl` for updating a text attribute.

### `components/UiBlock.js`

This component renders the main UI of the block.

-   Returns a `div` with a className of `modula-block-preview` and a simple message.

### `hooks/useBlockContext.js`

This custom hook provides a way to access the context.

-   Uses `useContext` to access `BlockContext`.
-   Throws an error if not used within a `BlockContextProvider`.

### `context/reducer.js`

This file exports a reducer function for use with `useReducer`.

-   Defines a `switch` statement with a default case that returns the current state.

### `context/state.js`

This file exports an `initialState` object.

### Data Fetching with SWR

We are utilizing the [SWR](https://swr.vercel.app/) library to handle data fetching within our block. SWR is a React Hooks library for remote data fetching and provides a clean and efficient way to fetch and manage data from our WordPress REST API. It is configured to use `apiFetch` from WordPress as the fetcher function, providing a seamless integration with the WordPress environment.

Here's a snippet on how it's being utilized in our block:

```javascript
import useSWR from 'swr';
import apiFetch from '@wordpress/api-fetch';

// this is already created in utils/fetcher.js
const fetcher = (...args) => apiFetch(...args);

export const UiBlock = () => {
    const { data, error } = useSWR('/wp/v2/modula-gallery', fetcher);

	console.log(data)
    // ... rest of the component
};

## Development Workflow

1. **Component Development**: Build and test individual components within the `components/` folder.
2. **State Management**: Define global state and actions within the `context/` folder.
3. **Styling**: Add or update styles in `editor.scss`.
4. **Block Logic**: Implement block logic within `edit.js`, utilizing components, context, and hooks as needed.

## Best Practices

-   Keep components small and focused on a single concern.
-   Use the `useBlockContext` hook to access global state within components.
-   Maintain a clean and organized folder structure to keep the codebase manageable.
```
