let opcoesRequisicoes = {
  "cadastro":(nomeDela) => {
    return [
    'envio/cadastrarClassificacao', {
    method: "POST",
    headers:{
      "Content-type": "application/json"
    },
    body : JSON.stringify({"nome":nomeDela})
  }]},
  "edicao":(paraEditar, novoValor) => {
    return [
    "envio/editarClassificacao",{
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
