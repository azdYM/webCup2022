import React, {useState} from 'react'
import { useFetch, useLoadFetchUrl } from '../hooks/useFetchUrl'
import Login from '../pages/auth/login'
import SignIn from '../pages/auth/signin'
import './navbar.css'

const Navbar = React.memo(({width, user=[]}) => {
    const {errors, loading, load} = useFetch('/api/users')

    const [login, setLogin] = useState(false)
    const [signin, setSignin] = useState(false)


    const handleSignUp = (e) => {
        e.preventDefault()

    }

    const handleLogIn = (e) => {
        e.preventDefault()
        console.log(e)
        
    }

    return <nav className='navbar'>
        <h2 className="logo"><a href="/">YOMA</a></h2>

        {login &&
            <Login onSubmit={handleLogIn} />
        }

        {signin && 
            <SignIn onSubmit={handleSignUp} />
        }
        
        {user.length === 0 && 
            <div className="link-auth">
                <button onClick={() => {setLogin({login: !login})}}  className='login blueBg' href="">Se connecter</button>
                <button onClick={() => {setSignin({signin: !signin})}} className='signin' href="">S'inscrire</button>
            </div>
        }
        {user.length > 1 &&
            <div className="auth">
                salut tous le monde
            </div>
        }
    </nav>
})

export default Navbar