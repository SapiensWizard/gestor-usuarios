/**
 * Descobrir a altura exata do header
 */

const header = document.querySelector("header");

if (header) {
  const headerHeight = header.offsetHeight;
  console.log(`Altura do header: ${headerHeight}px`);
} else {
  console.warn("Elemento <header> não encontrado.");
}
