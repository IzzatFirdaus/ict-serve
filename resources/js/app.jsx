import React from "react";
import { createRoot } from "react-dom/client";
import { Button } from "@govtechmy/myds-react/button";

const container = document.getElementById("app");
if (container) {
    const root = createRoot(container);
    root.render(<Button variant="primary-fill">Hello MYDS</Button>);
}
