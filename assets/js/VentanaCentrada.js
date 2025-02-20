function VentanaCentrada(theURL, winName, features, myWidth, myHeight, isCenter) {
  // Verificar si la ventana del navegador admite la pantalla
  if (window.screen && isCenter === "true") {
    const myLeft = (screen.width - myWidth) / 2;
    const myTop = (screen.height - myHeight) / 2;
    features += (features !== '') ? ',' : '';
    features += `left=${myLeft},top=${myTop}`;
  }
  window.open(theURL, winName, `${features}${features !== '' ? ',' : ''}width=${myWidth},height=${myHeight}`);
}
