export async function addToDatabase(value) {
  try {
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
}
