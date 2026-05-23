export async function registerNewUser(value) {

  try {
    db = await fetch('../api/Register.php', {
      method: 'POST',
      body: value
    })
  } catch (e) {
    throw new Error(e);
  }
}
