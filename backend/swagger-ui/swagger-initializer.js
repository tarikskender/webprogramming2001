window.onload = () => {
    window.ui = SwaggerUIBundle({
      url: "lifemaxxer.yaml", // Make sure this file is in the same folder
      dom_id: '#swagger-ui',
      deepLinking: true,
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      layout: "StandaloneLayout"
    });
  };
  