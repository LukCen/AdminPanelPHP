export async function addToDatabase(value) {
  const loader = document.querySelector(`.dbc[data-id="${value}"]>.lucide-loader-icon`)
  try {
    loader.classList.remove('hidden')
    const db = await fetch('../api/AddRowToDatabase.php', {
      method: 'POST',
      body: value
    })

    const data = await db.json()
    if (data.success) {
      console.log('Adding successful')
      const marker = document.querySelector(`.database-add-marker[data-id="${value}"]`)
      if (marker) {
        marker.classList.toggle('hidden')
        setTimeout(() => {
          marker.classList.toggle('hidden')
        }, 3000)
      }

    }
  } catch (err) {
    throw new Error(`Adding to database unsuccessful: ${err}.`)
  }
  finally {
    loader.classList.add('hidden')
  }
}

export async function removeFromDb(value) {
  const loader = document.querySelector(`.dbr[data-id="${value}"]>.lucide-loader-icon`)
  console.log('removing...')
  try {
    loader.classList.remove('hidden')
    const db = await fetch('../api/RemoveRowFromDatabase.php', {
      method: 'POST',
      body: value
    })

    const data = await db.json()

    if (data.success) {
      console.log("game removal successful")
    }
  } catch (err) {
    throw new Error(`Removing from database unsuccessful: ${err}.`)
  }
  finally {
    loader.classList.add('hidden')
  }
}
