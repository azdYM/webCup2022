import React, {useCallback, useState} from 'react'

async function jsonFetch (url, method="GET", data = null) {
    
    const params = {
        method: method,
        headers: {
            'Accept': 'application/ld+json',
            'Content-Type': 'application/json'
        }
    }

    if (data) {
        params.body = JSON.stringify(data)
    }
    
    const response = await fetch(url, params)
    
    if (response.status === 204) {
        return null
    }

    const responseData = await response.json()
    if (response.ok) {
        return responseData
    } else {
        throw responseData
    }
}

const useLoadFetchUrl = (url, method="GET") => {
    const [data, setData] = useState([])
    const [loading, setLoading] = useState(false)
    const [error, setError] = useState(null)
    
    const load = useCallback(async(data) => {
        setLoading(true)
        try {
            const response = await jsonFetch(url, method, data)
            setData(response)
        } catch (e) {

            if (!(e instanceof DOMException) || e.code !== e.ABORT_ERR) {
                setError(e)
            }
        }

        setLoading(false)

    }, [url])

    return {
        data,
        loading,
        error,
        load
    }
}

const useFetch = (url, method="POST", callback = null) => {
    
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)

    const load = useCallback(async (data) => {

        setLoading(true)
        try {
            const response = await jsonFetch(url, method, data)
            callback(response)
        } catch (errors) {

            setErrors(errors)
        }
        setLoading(false)

    }, [url, method, callback])

    return {errors, loading, load}
}

const uploadFile = (url, method='POST') => {

    const [file, setFile] = useState({fileLoaded: 0, fileTotal: 0})

    const loadFile = useCallback((form) => {
        let xhr = new XMLHttpRequest()
        let formData = new FormData(form)

        xhr.open(method, url) 
        xhr.upload.addEventListener("progress", ({loaded, total}) => {
            
            let fileLoaded = Math.floor((loaded / total) * 100) //Avoir le pourcentage
            let fileTotal = Math.floor(loaded / 1000) // avoir la taille du fichier en KB
            
            setFile({
                fileLoaded: fileLoaded,
                fileTotal: fileTotal
            })
        })
    
        xhr.send(formData)

    }, [url])

    return {file, loadFile}
}

export {useLoadFetchUrl, uploadFile, useFetch}