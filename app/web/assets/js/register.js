window.OBJRegister = {
  async sendForm(formRegister) {

    if (formRegister && formRegister.checkValidity()) {
      const ObjForm = Utils.traitElement(formRegister)

      if (Object.values(ObjForm).length) {
        const response = await fetch('/users/register', {
          method: 'POST',
          body: JSON.stringify(ObjForm)
        })

        if (response.ok) {
          const { message, error } = await response.json()

          if (error) {
            alert(error)
            return formRegister.reset()
          }

          alert(message)
          location.href = '/';
        }
      }
    }
  },
}
