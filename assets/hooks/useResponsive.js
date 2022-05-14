import { useCallback, useEffect, useState } from "react"

export default function useResponsive () 
{
    const [width, setWidth] = useState(null)
    
    const updateWidth = () => {
        setWidth(window.innerWidth)
    }

    const responsive = useCallback(() => {
        updateWidth ()
        window.addEventListener('resize', updateWidth)

    }, [width])

    return [width, responsive]
}
