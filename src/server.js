const express = require("express");
const app = express();

const PORT = process.env.PORT || 3000;

/* =========================
   REDIRECTION PRINCIPALE
========================= */
app.get("/", (req, res) => {
  res.redirect("https://api-bankaires.onrender.com/api-docs");
});

/* =========================
   (optionnel) fallback
========================= */
app.use((req, res) => {
  res.redirect("https://api-bankaires.onrender.com/api-docs");
});

/* =========================
   START SERVER
========================= */
app.listen(PORT, () => {
  console.log(`Redirect server running on port ${PORT}`);
});