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
    }
  } catch (err) {
    throw new Error(`Adding to database unsuccessful: ${err}.`)
  }
}
