import React from 'react'
import './auth.css'

const Login = ({onSubmit}) => {
    return <div className="auth">
        <div className="in">
            <div className="close"><span></span><span></span></div>
            <div className="form-content">
                <h1>CONNEXION</h1>
                <form method="post" onSubmit={(e) => onSubmit(e)}>
                    <div className="field">
                        <input type="text" placeholder='email'/>
                    </div>
                    <div className="field">
                        <input type="text" placeholder='mot de passe'/>
                    </div>
                    <button className='blueBg'  type="submit">Se connecter</button>
                </form>
            </div>
            <div className="banner-image">

            </div>
        </div>
    </div>
}

export default Login