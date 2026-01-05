export async function addToDatabase(value) {
  console.log(value)
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
        marker.innerText = "Added to database!"
        setTimeout(() => {
          marker.innerText = ""
        }, 5000)
      }
    }
  } catch (err) {
    throw new Error(`Adding to database unsuccessful: ${err}.`)
  }
}
