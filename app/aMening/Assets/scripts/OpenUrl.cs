using UnityEngine;
using System.Collections;

public class OpenUrl : MonoBehaviour {
    public string url;
	public void OpenUrlPage()
    {
        Application.OpenURL(url);
    }
}
