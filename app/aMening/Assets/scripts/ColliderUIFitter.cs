using UnityEngine;
using System.Collections;
using System.Linq;
[RequireComponent(typeof(BoxCollider), typeof(RectTransform))]
public class ColliderUIFitter : MonoBehaviour {

    RectTransform t;
    BoxCollider b;
    public bool updateValues = false;
    public float yOffset = 0;
    public float yMultipier = 0;

    void Start ()
    {
        t = GetComponent<RectTransform>();
        b = GetComponent<BoxCollider>();
        if (!updateValues)
        {
            updateValues = true;
            Update();
            updateValues = false;
        }
    }
	
	// Update is called once per frame
	void Update () {
        if (updateValues)
        {
            Vector3[] v = new Vector3[4];
            t.GetWorldCorners(v);
            b.size = new Vector3(v.Max(e => e.x) - v.Min(e => e.x), v.Max(e => e.y) - v.Min(e => e.y), 1);
            b.center = new Vector3(0, b.size.y / 2 * ((1-t.pivot.y)*2-1) +  yOffset, 0);
        }
    }
}
