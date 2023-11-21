let opcoesRequisicoes = {
  "cadastro":(nomeDela) => {
    return [
    '/Sistema-de-pedidos-TCC/envio/cadastrarClassificacao', {
    method: "POST",
    headers:{
      "Content-type": "application/json"
    },
    body : JSON.stringify({"nome":nomeDela})
  }]},
  "edicao":(paraEditar, novoValor) => {
    return [
    "/Sistema-de-pedidos-TCC/envio/editarClassificacao",{
      method:"POST",
      headers:{
        "Content-type": "application/json"
      },
      body: JSON.stringify({
        "paraEditar":paraEditar,
        "novoValor" : novoValor
      })
    }]},
    "excluir": (paraExcluir) => {
      return [
        "envio/excluirClassificacao",{
          method:"POST",
          headers:{
            "Content-type" : "application/json"
          },
          body: JSON.stringify({
            "paraExcluir":paraExcluir
          })
        }]}
}
