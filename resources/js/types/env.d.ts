/// <reference types="vite/client" />

interface ImportMetaEnv {
 // ... could include environment variables

 /** APP NAME */
 readonly VITE_APP_NAME: string;
}

interface ImportMeta {
 readonly env: ImportMetaEnv;
}
