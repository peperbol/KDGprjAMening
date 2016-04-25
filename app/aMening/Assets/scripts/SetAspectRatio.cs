using UnityEngine;
using System.Collections;

public class SetAspectRatio : MonoBehaviour {
    public Material m;
    RectTransform r;
    void Start() {
        r = GetComponent<RectTransform>();
    }
	void Update () {
        m.SetFloat("_AspectRatio", r.rect.size.x / r.rect.size.y);
	}
}
