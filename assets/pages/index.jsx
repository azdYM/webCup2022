import useResponsive from "../hooks/useResponsive"
import React, {useEffect} from 'react'
import ReactDom, {render} from 'react-dom'
import Navbar from "../components/Navbar"
import { useLoadFetchUrl } from '../hooks/useFetchUrl'

function Home () 
{
    const [width, responsive] = useResponsive()
    const {data: currentUser, loading: loadingUser, load: getUserCurrent } = useLoadFetchUrl('/api/me')
    
    useEffect(() => {getUserCurrent()}, [])
    useEffect(() => responsive(), [])

    return <div className="container">
        {loadingUser === false && 
            <Navbar 
                width={width} 
                user={currentUser}
            />
        }
    </div>
}

class HomeElements extends HTMLElement {
    
    connectedCallback () {
        console.log('salut tous le monde')
        render(<Home />, this)
    }
}

customElements.define('home-react', HomeElements)

