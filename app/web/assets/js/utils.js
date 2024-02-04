window.Utils = {
  traitElement(elem) {
    let result = {}

    for (let i= 0; i < elem.length; i++) {
      if (elem[i].value) {
        result[elem[i].name] = elem[i].value
      }
    }

    return result
  }
}
