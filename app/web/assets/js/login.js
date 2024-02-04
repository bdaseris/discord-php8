window.OBJLogin = {
  
  async sendForm(formLogin) {
    
    if (formLogin && formLogin.checkValidity()) {
      const ObjForm = Utils.traitElement(formLogin)
      
      if (Object.values(ObjForm).length) {
        const response = await fetch('/login', { 
          method: 'POST',
          body: JSON.stringify(ObjForm)
        })
        
        if (response.ok) {
          const { error } = await response.json()
          
          if (error) {
            alert(error)
            return formLogin.reset()
          }
 
          location.href = '/';
        }
      }
    }
  },
  
  logout() {
    fetch('/logout')
      .then(() => location.href = '/')    
  },
}
